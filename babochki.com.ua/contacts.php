<?PHP
 
function show_form()
{
?>
<form class="contacts" action="contacts.php" enctype="text/plain" method="post" id="contact-form">
  <p>Отправить сообщение. Все поля, отмеченные звездочкой, являются обязательными.</p>
  <div class="table">
    
    <div class="table-row">
      <label for="name" required"title="">Имя<span>&nbsp;*</span></label>
      <span><input type="text" name="name" id="name" value="" required size="18"></span>    
      </div>
    
    <div class="table-row">
      <label for="email"required title="">E-mail<span>&nbsp;*</span></label>
      <span><input type="E-mail" name="email" required id="email" value="" size="18"></span>    
      </div>
    
    <div class="table-row">
      <label for="title" required title="">Тема<span>&nbsp;*</span></label>
      <span><input type="text" name="title" id="title" value="" required size="18"></span>    
      </div>
    
    <div class="table-row">
      <span class="top"><label id="" for="mess" required title="">Сообщение<span>&nbsp;*</span></label></span>    
      <span><textarea name="mess" id="mess"  required>        
      </textarea></span>    
      </div>
    </div>
    <div class="submit">
    <input type="submit" value="Отправить сообщение"></input>
  </div>
  </form>
<?
} 
 
function complete_mail() {
        // $_POST['title'] містить дані з поля "Тема", trim() - забираємо всі лишні пробіли і переноси рядків, htmlspecialchars() - переобразує спеціальні символи в HTML по суті, для того, щоб самі прості спроби взламати сайт не вийшли, ну і  substr($_POST['title'], 0, 1000) - зменшуємо текст до 1000 символів. Для змінних $_POST['mess'], $_POST['name'], $_POST['tel'], $_POST['email'] все аналогічно
        $_POST['title'] =  substr(htmlspecialchars(trim($_POST['title'])), 0, 1000);
        $_POST['mess'] =  substr(htmlspecialchars(trim($_POST['mess'])), 0, 1000000);
        $_POST['name'] =  substr(htmlspecialchars(trim($_POST['name'])), 0, 30);
        $_POST['email'] =  substr(htmlspecialchars(trim($_POST['email'])), 0, 50);
        // якщо не заповнене поле "Імя" - показуемо помилку 0
        if (empty($_POST['name']))
             output_err(0);
        // якщо не правильно заповнене поле email - показуемо помилку 1
        if(!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $_POST['email']))
             output_err(1);
        // якщо не заповнено поле "Повідомлення" - показуемо помилку 2
        if(empty($_POST['mess']))
             output_err(2);
        // створюємо наше повідомлення
        $mess = '
Імя відправника:'.$_POST['name'].'
Контактний email:'.$_POST['email'].'
'.$_POST['mess'];
        // $to - кому відправляємо
        $to = 'anm2004@ukr';
        // $from - від кого
        $from='test@test.ua';
        mail($to, $_POST['title'], $mess, "From:".$from);
        echo 'Дякую! Ваш лист відісланий.';
} 
 
function output_err($num)
{
    $err[0] = 'ПОМИЛКА! Не введено імя.';
    $err[1] = 'ПОМИЛКА! Невірно введений e-mail.';
    $err[2] = 'ПОМИЛКА! Не введено повідомлення.';
    echo '<p>'.$err[$num].'</p>';
    show_form();
    exit();
} 
 
if (!empty($_POST['submit'])) complete_mail();
else show_form();
 ?>