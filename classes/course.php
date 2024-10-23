<?php
class Course {
    private $conn;

    // Phương thức khởi tạo để thiết lập kết nối CSDL
    public function __construct() {
        session_start();

        // Kiểm tra xem session có tồn tại thông tin kết nối hay không
        if (!isset($_SESSION['server']) || !isset($_SESSION['database']) || !isset($_SESSION['username']) || !isset($_SESSION['password'])) {
            die("Thông tin kết nối không tồn tại trong session.");
        }

        // Lấy thông tin kết nối từ session
        $server = $_SESSION['server'];
        $database = $_SESSION['database'];
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];

        // Kết nối cơ sở dữ liệu
        $this->conn = new mysqli($server, $username, $password, $database);

        if ($this->conn->connect_error) {
            die("Kết nối thất bại: " . $this->conn->connect_error);
        }
    }

    // Phương thức lấy danh sách khóa học từ database
    public function getCourses() {
        $sql = "SELECT * FROM Course";  
        $result = $this->conn->query($sql);

        $courses = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $courses[] = $row;
            }
        } else {
            echo "Không có khóa học nào.";
        }
        return $courses;
    }
    
    // Phương thức ghi danh sách khóa học vào file
    public function writeToFile($filename, $courses) {
        $filename .= ".txt";  // Thêm đuôi .txt vào tên file

        // Kiểm tra nếu file đã tồn tại hay chưa
        if (file_exists($filename)) {
            echo "File đã tồn tại. Ghi đè lên file hiện có.\n";
        } else {
            echo "File chưa tồn tại. Tạo file mới.\n";
        }

        // Mở hoặc tạo file để ghi dữ liệu (chế độ 'w' ghi đè nếu file đã tồn tại)
        $file = fopen($filename, "w");

        if ($file) {
            // Ghi tiêu đề vào file
            fwrite($file, "Danh sách khóa học:\n");
            // fwrite($file, "--------------------\n");

            // Ghi danh sách khóa học vào file
            foreach ($courses as $course) {
                fwrite($file, "Tên khóa học: " . $course['Title'] . "\n");
                fwrite($file, "Mô tả: " . $course['Description'] . "\n");
                fwrite($file, "Đường dẫn tới hình ảnh: " . $course['ImageUrl'] . "\n");
                fwrite($file, "--------------------\n");
            }

            fclose($file);
            echo "File đã được ghi thành công!";
        } else {
            echo "Không thể mở file để ghi.";
        }
    }
    // Phương thức hủy để đóng kết nối CSDL
    public function __destruct() {
        $this->conn->close();
    }
}
?>
