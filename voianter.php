<?php
// الاتصال بقاعدة البيانات
$servername = "localhost";  // عادة يكون "localhost"
$username = "root";  // اسم المستخدم لقاعدة البيانات (يجب تغييره إذا كان مختلفًا)
$password = "root";  // كلمة المرور لقاعدة البيانات (يجب تعديلها إذا كانت موجودة)
$dbname = "blood_donation";  // اسم قاعدة البيانات

// إنشاء اتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// التحقق من إرسال البيانات عن طريق POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullName'];
    $phone = $_POST['phone'];
    $governorate = $_POST['governorate'];
    $bloodType = $_POST['bloodType'];
    $age = $_POST['age'];

    // تحضير وإدخال البيانات في قاعدة البيانات باستخدام Prepared Statements للحماية من SQL Injection
    $stmt = $conn->prepare("INSERT INTO donors (fullName, phone, governorate, bloodType, age) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $fullName, $phone, $governorate, $bloodType, $age);

    if ($stmt->execute()) {
        echo "تم إرسال طلب التبرع بالدم بنجاح!";
    } else {
        echo "حدث خطأ أثناء إرسال البيانات: " . $stmt->error;
    }

    // إغلاق الاتصال
    $stmt->close();
    $conn->close();
}
?>
