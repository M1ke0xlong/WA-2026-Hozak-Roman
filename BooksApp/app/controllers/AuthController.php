<?php

class AuthController {

    // 1. Zobrazení registračního formuláře
    public function register() {
        require_once '../app/views/auth/register.php';
    }

    // 2. Zpracování dat z registrace
    // 2. Zpracování dat z registrace
    public function storeUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Očištění textových vstupů
            $username = htmlspecialchars($_POST['username'] ?? '');
            $email = htmlspecialchars($_POST['email'] ?? '');
            $firstName = htmlspecialchars($_POST['first_name'] ?? '');
            $lastName = htmlspecialchars($_POST['last_name'] ?? '');
            $nickname = htmlspecialchars($_POST['nickname'] ?? '');
            
            $password = $_POST['password'] ?? '';
            $passwordConfirm = $_POST['password_confirm'] ?? '';

            // 1. Základní validace povinných polí
            if (empty($username) || empty($email) || empty($password)) {
                $this->addErrorMessage('Vyplňte prosím všechna povinná pole.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/register');
                exit;
            }

            // 2. Kontrola shody hesel
            if ($password !== $passwordConfirm) {
                $this->addErrorMessage('Zadaná hesla se neshodují.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/register');
                exit;
            }

            // --- 3. HARDCORE VALIDACE HESLA ---
            $isTooShort = mb_strlen($password) < 8;
            $hasNoNumber = !preg_match('/[0-9]/', $password);
            $hasNoSpecial = !preg_match('/[^a-zA-Z0-9]/', $password); // Hledá cokoli jiného než písmena a čísla

            if ($isTooShort || $hasNoNumber || $hasNoSpecial) {
                $this->addErrorMessage('Heslo je příliš slabé! Musí mít alespoň 8 znaků, obsahovat číslici a alespoň jeden speciální znak (např. !, @, #, $).');
                header('Location: ' . BASE_URL . '/index.php?url=auth/register');
                exit;
            }
            // --- KONEC VALIDACE ---

            // Napojení na DB a Model
            require_once '../app/models/Database.php';
            require_once '../app/models/User.php';
            
            $db = (new Database())->getConnection();
            $userModel = new User($db);

            // Pokus o uložení
            if ($userModel->register($username, $email, $password, $firstName, $lastName, $nickname)) {
                $this->addSuccessMessage('Registrace byla úspěšná. Nyní se můžete přihlásit.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
                exit;
            } else {
                $this->addErrorMessage('Uživatel s tímto e-mailem již existuje.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/register');
                exit;
            }
        }
    }

    // 3. Zobrazení přihlašovacího formuláře
    public function login() {
        require_once '../app/views/auth/login.php';
    }

    // 4. Zpracování přihlášení
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = htmlspecialchars($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            require_once '../app/models/Database.php';
            require_once '../app/models/User.php';
            
            $db = (new Database())->getConnection();
            $userModel = new User($db);

            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = !empty($user['nickname']) ? $user['nickname'] : $user['username'];
                $_SESSION['is_admin'] = $user['is_admin']; 
                $this->addSuccessMessage('Vítejte zpět, ' . $_SESSION['user_name'] . '!');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            } else {
                $this->addErrorMessage('Nesprávný e-mail nebo heslo.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
                exit;
            }
        }
    }

    // 5. Odhlášení uživatele
    public function logout() {
    session_start(); // Musí tu být, jinak PHP neví, jakou session mazat
    session_unset(); // Vymaže všechny proměnné v session
    session_destroy(); // Úplně session zničí
    $this->addSuccessMessage('Byli jste úspěšně odhlášeni.');
    header('Location: ' . BASE_URL . '/index.php');
    exit;
}

    // --- Pomocné metody pro notifikace (Sjednoceny na flash_messages pro tvůj styl) ---
    protected function addSuccessMessage($message) {
        $_SESSION['flash_messages'][] = ['type' => 'success', 'text' => $message];
    }

    protected function addNoticeMessage($message) {
        $_SESSION['flash_messages'][] = ['type' => 'notice', 'text' => $message];
    }

    protected function addErrorMessage($message) {
        $_SESSION['flash_messages'][] = ['type' => 'error', 'text' => $message];
    }
}