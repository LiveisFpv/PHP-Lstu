<?php
    namespace src\lib\files;

    class Files{
        public static function save($file) : string {
            
            $fileName = "data.csv";
            $fileTmpPath = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileType = $file['type'];
            $uploadDir = __DIR__ . '/../uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $destination = $uploadDir . basename($fileName);
            if (!move_uploaded_file($fileTmpPath, $destination)) {
                return "Ошибка при загрузке файла.";
            }
            return "";
        }
    }
?>