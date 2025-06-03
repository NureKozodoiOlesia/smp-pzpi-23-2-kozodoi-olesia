<?php
$profileFile = 'user_profile.json';
$uploadDir = 'uploads/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$profileData = [];
if (file_exists($profileFile)) {
    $profileData = json_decode(file_get_contents($profileFile), true) ?: [];
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $surname = trim($_POST['surname'] ?? '');
    $birthDate = $_POST['birth_date'] ?? '';
    $description = trim($_POST['description'] ?? '');
    
    if (empty($name) || empty($surname) || empty($birthDate) || empty($description)) {
        $error = 'Всі поля обов\'язкові для заповнення';
    } elseif (strlen($name) < 2 || strlen($surname) < 2) {
        $error = 'Ім\'я та прізвище повинні містити більше одного символу';
    } elseif (!preg_match('/^[a-zA-Zа-яА-ЯїЇєЄіІ\s]+$/u', $name) || !preg_match('/^[a-zA-Zа-яА-ЯїЇєЄіІ\s]+$/u', $surname)) {
        $error = 'Ім\'я та прізвище повинні містити тільки літери';
    } elseif (strlen($description) < 50) {
        $error = 'Стисла інформація повинна містити не менше 50 символів';
    } else {
        // Перевірка віку
        $birthDateTime = DateTime::createFromFormat('Y-m-d', $birthDate);
        if (!$birthDateTime) {
            $error = 'Неправильний формат дати народження';
        } else {
            $now = new DateTime();
            $age = $now->diff($birthDateTime)->y;
            
            if ($age < 16) {
                $error = 'Користувачеві має бути не менше 16 років';
            } else {
                $photoPath = $profileData['photo'] ?? '';
                
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    $fileType = $_FILES['photo']['type'];
                    
                    if (!in_array($fileType, $allowedTypes)) {
                        $error = 'Дозволені тільки файли JPG, PNG, GIF';
                    } elseif ($_FILES['photo']['size'] > 5 * 1024 * 1024) { // 5MB
                        $error = 'Розмір файлу не повинен перевищувати 5MB';
                    } else {
                        $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                        $newFileName = 'profile_' . time() . '.' . $extension;
                        $uploadPath = $uploadDir . $newFileName;
                        
                        if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadPath)) {
                            if ($photoPath && file_exists($photoPath)) {
                                unlink($photoPath);
                            }
                            $photoPath = $uploadPath;
                        } else {
                            $error = 'Помилка завантаження файлу';
                        }
                    }
                } elseif (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
                    $error = 'Помилка завантаження файлу. Спробуйте ще раз.';
                }
                
                if (!$error) {
                    $profileData = [
                        'name' => $name,
                        'surname' => $surname,
                        'birth_date' => $birthDate,
                        'description' => $description,
                        'photo' => $photoPath
                    ];
                    
                    if (file_put_contents($profileFile, json_encode($profileData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
                        $success = 'Профіль успішно збережено!';
                    } else {
                        $error = 'Помилка збереження даних';
                    }
                }
            }
        }
    }
}

$hasValidPhoto = !empty($profileData['photo']) && file_exists($profileData['photo']);
if (!$hasValidPhoto && !empty($profileData['photo'])) {
    $profileData['photo'] = '';
    file_put_contents($profileFile, json_encode($profileData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
?>

<h1>Профіль користувача</h1>

<?php if ($error): ?>
    <p style="color: red; font-weight: bold;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<?php if ($success): ?>
    <p style="color: green; font-weight: bold;"><?= htmlspecialchars($success) ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" style="max-width: 600px; margin: 0 auto;">
    <table style="margin: 0 auto; width: 100%;">
        <tr>
            <td colspan="2" style="text-align: center; padding-bottom: 20px;">
                <?php if ($hasValidPhoto): ?>
                    <img src="<?= htmlspecialchars($profileData['photo']) ?>" 
                         style="width: 150px; height: 150px; object-fit: cover; border-radius: 10px; border: 2px solid #ddd;" 
                         alt="Фото профілю">
                <?php else: ?>
                    <div style="width: 150px; height: 150px; border: 2px dashed #ccc; 
                                display: inline-flex; align-items: center; justify-content: center; 
                                border-radius: 10px; color: #666; margin: 0 auto;">
                        Немає фото
                    </div>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: right; padding: 10px;"><label for="name">Ім'я:</label></td>
            <td style="padding: 10px;">
                <input type="text" id="name" name="name" 
                       value="<?= htmlspecialchars($profileData['name'] ?? '') ?>" 
                       style="width: 200px; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
            </td>
        </tr>
        <tr>
            <td style="text-align: right; padding: 10px;"><label for="surname">Прізвище:</label></td>
            <td style="padding: 10px;">
                <input type="text" id="surname" name="surname" 
                       value="<?= htmlspecialchars($profileData['surname'] ?? '') ?>" 
                       style="width: 200px; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
            </td>
        </tr>
        <tr>
            <td style="text-align: right; padding: 10px;"><label for="birth_date">Дата народження:</label></td>
            <td style="padding: 10px;">
                <input type="date" id="birth_date" name="birth_date" 
                       value="<?= htmlspecialchars($profileData['birth_date'] ?? '') ?>" 
                       style="width: 200px; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
            </td>
        </tr>
        <tr>
            <td style="text-align: right; padding: 10px; vertical-align: top;"><label for="description">Стисла інформація:</label></td>
            <td style="padding: 10px;">
                <textarea id="description" name="description" rows="5" 
                          style="width: 300px; padding: 8px; border: 1px solid #ccc; border-radius: 4px; resize: vertical;" 
                          placeholder="Розкажіть про себе (мінімум 50 символів)" required><?= htmlspecialchars($profileData['description'] ?? '') ?></textarea>
            </td>
        </tr>
        <tr>
            <td style="text-align: right; padding: 10px;"><label for="photo">Фото:</label></td>
            <td style="padding: 10px;">
                <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/gif" 
                       style="padding: 8px;">
                <br><small style="color: #666;">Дозволені формати: JPG, PNG, GIF. Максимальний розмір: 5MB</small>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center; padding-top: 20px;">
                <button type="submit" style="padding: 12px 30px; font-size: 16px;">Зберегти</button>
            </td>
        </tr>
    </table>
</form>
