<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">PHP Example</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                    aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        <a class="nav-link" href="connect.php">Connect MySQL</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="container my-3">
        <nav class="alert alert-primary" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Index</li>
            </ol>
        </nav>

        <!-- Hiển thị các khóa học từ cơ sở dữ liệu -->
    <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php
        if (isset($_SESSION['server']) && isset($_SESSION['database']) && isset($_SESSION['username']) && isset($_SESSION['password'])) {
            $server = $_SESSION['server'];
            $database = $_SESSION['database'];
            $username = $_SESSION['username'];
            $password = $_SESSION['password'];

            // Kết nối đến cơ sở dữ liệu
            $conn = new mysqli($server, $username, $password, $database);

            if ($conn->connect_error) {
                die("Kết nối thất bại: " . $conn->connect_error);
            }

            // Truy vấn danh sách khóa học
            $sql = "SELECT * FROM course";
            $result = $conn->query($sql);
        
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '
                        <div class="col">
                            <div class="card">
                                <img src="' . $row["ImageUrl"] . '" class="card-img-top" alt="' . $row["Title"] . '">
                                <div class="card-body">
                                    <h5 class="card-title">' . $row["Title"] . '</h5>
                                    <p class="card-text">' . $row["Description"] . '</p>
                                </div>
                            </div>
                        </div>';
                }
            } else {
                echo "<p>Không có khóa học nào.</p>";
            }
        } else {
            echo "Chưa có thông tin kết nối.";
        }
            ?>
        </div>

        <hr>
        <form class="row" method="POST" enctype="multipart/form-data">
            <div class="col">
                <div class="form-floating mb-3">
                    <input value="data" type="text" class="form-control" id="server" placeholder="File name" name="filename">
                    <label for="data">File name</label>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Write file</button>
            </div>
            <div class="col">
            </div>
        </form>
    </div>

    <?php
        if (isset($_POST['submit'])) {
            $filename = $_POST['filename'];

            // Kiểm tra xem file đã tồn tại chưa
            if (file_exists($filename . '.txt')) {
                $file = fopen($filename . '.txt', 'w'); // Mở file và ghi đè nội dung
                fwrite($file, "Nội dung mới đã ghi đè lên file cũ.");
            } else {
                $file = fopen($filename . '.txt', 'w'); // Tạo file mới
                fwrite($file, "File mới đã được tạo và nội dung đã được ghi.");
            }
            fclose($file);

            echo '<div class="alert alert-success">File đã được ghi thành công.</div>';
        }
    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>