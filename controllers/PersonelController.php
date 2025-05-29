<?php
require_once __DIR__ . '/../models/User.php';

class PersonelController
{
    public function personelList()
    {
        $model = new User();
        $personelList = $model->getAllPersonnel();
        $title = "Personel İşlemleri";
        $content = BASE_PATH . '/views/dashboard/admin/personel-management.php';
        require BASE_PATH . '/views/layout.php';
    }

    public function personelAdd()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new User();
            $full_name = $_POST['full_name'];
            $tc_no = $_POST['tc_no'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $password = $_POST['password'];
            $role = $_POST['role'];
            $model->addPersonnel($full_name, $tc_no, $email, $phone, $password, $role);
            header("Location: index.php?page=personelList");
            exit;
        }
    }

    public function personelEdit() {
        $id = $_GET['id'] ?? null;
        if (!$id) { header("Location: index.php?page=personelList"); exit; }
        $model = new User();
        $personel = $model->getPersonnelById($id);
        if (!$personel) { header("Location: index.php?page=personelList"); exit; }
        $title = "Personel Düzenle";
        $content = BASE_PATH . '/views/dashboard/admin/personel-edit.php';
        require BASE_PATH . '/views/layout.php';
    }

    public function personelUpdate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new User();
            $id = $_POST['id'];
            $full_name = $_POST['full_name'];
            $tc_no = $_POST['tc_no'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $role = $_POST['role'];
            // Şifre boşsa değişmesin
            $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
            $model->updatePersonnel($id, $full_name, $tc_no, $email, $phone, $role, $password);
            header("Location: index.php?page=personelList");
            exit;
        }
    }

    public function personelDelete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
            $model = new User();
            $model->deletePersonnel($_POST['user_id']);
            header("Location: index.php?page=personelList");
            exit;
        }
    }
}
