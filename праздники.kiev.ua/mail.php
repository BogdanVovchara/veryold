<?PHP
 function complete_mail() {
        // $_POST['subject'] містить дані з поля "Тема", trim() - забираємо всі лишні пробіли і переноси рядків, htmlspecialchars() - перетворює спеціальні символи в HTML по суті, для того, щоб самі прості спроби взламати сайт не вийшли, ну і  substr($_POST['subject'], 0, 1000) - зменшуємо текст до 1000 символів. Для змінних $_POST['message'], $_POST['name'], $_POST['tel'], $_POST['email'] все аналогічно
        $_POST['name'] =  substr(htmlspecialchars(trim($_POST['name'])), 0, 30);
        $_POST['email'] =  substr(htmlspecialchars(trim($_POST['email'])), 0, 50);
        $_POST['subject'] =  substr(htmlspecialchars(trim($_POST['subject'])), 0, 1000);
        $_POST['message'] =  substr(htmlspecialchars(trim($_POST['message'])), 0, 1000000);
         $_POST['tel'] =  substr(htmlspecialchars(trim($_POST['tel'])), 0, 1000000);  
        // якщо не заповнене поле "Імя" - показуємо помилку 0
        if (empty($_POST['name']))
             output_err(0);
        // якщо не правильно заповнене поле email - показуємо помилку 1
        if(!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $_POST['email']))
             output_err(1);
        // якщо не заповнено поле "Повідомлення" - показуємо помилку 2
        if(empty($_POST['message']))
             output_err(2);
         if(!empty($_POST['tel']))
             output_err(3);            
        // якщо не заповнено поле "Повідомлення" - показуємо помилку 3
        // створюємо наше повідомлення
        $message = '
Імя відправника:'.$_POST['name'].'
Контактний email:'.$_POST['email'].'
'.$_POST['message'];
        // $to - кому відправляємо
        $to = 'test.gmail.com';
        // $from - від кого
        $from='contact-form';
        mail($to, $_POST['subject'], $message, "From:".$from);
        echo 'Дякуємо ваш лист відправлений.';
} 
 
function output_err($num)
{
    $err[0] = 'ПОМИЛКА! Не введене імя.';
    $err[1] = 'ПОМИЛКА! Невірно введений e-mail.';
    $err[2] = 'ПОМИЛКА! Не введене повідомлення.';
    $err[3] = 'ПОМИЛКА! Автозаповнення програмою.';    
    echo '<p>'.$err[$num].'</p>';
    exit();
} 
 
if (!empty($_POST['sendMail'])) complete_mail();
?>