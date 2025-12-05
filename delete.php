<?php
session_start();
include "config.php";

// Cek admin
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

if(isset($_GET['id']) && isset($_GET['type'])){
    $id = $_GET['id'];
    $type = $_GET['type'];

    if($type == 'pdf'){
        // Hapus File Fisik + Data Database
        if(isset($_GET['file'])){
            $filePath = urldecode($_GET['file']);
            if(file_exists($filePath)){
                unlink($filePath); // Menghapus file dari folder uploads
            }
        }
        $query = "DELETE FROM pdf_files WHERE id='$id'";
        mysqli_query($conn, $query);
        
        echo "<script>alert('PDF Berhasil dihapus!'); window.location='admin.php';</script>";
    
    } elseif ($type == 'req'){
        // Hapus Request
        $query = "DELETE FROM requests WHERE id='$id'";
        mysqli_query($conn, $query);
        
        echo "<script>alert('Request dihapus!'); window.location='admin.php';</script>";
    }
} else {
    header("Location: admin.php");
}
?>