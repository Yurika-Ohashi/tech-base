<?php
    $namae="名前";
    $komento="コメント";
    
    $dsn = ʼデータベース名ʼ ;
    $user = ʼユーザー名ʼ ;
    $password = ʼパスワードʼ;
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    $sql = "CREATE TABLE IF NOT EXISTS keijiban"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT"
    .");";
    $stmt = $pdo->query($sql);
        
    if(!empty($_POST["name"])&&!empty($_POST["comment"])&&empty($_POST["hensyunumber"])&&($_POST["password"])=="candyapple"){
        $name=$_POST["name"];
        $comment=$_POST["comment"];
        
        $sql = $pdo -> prepare("INSERT INTO keijiban (name, comment) VALUES (:name, :comment)");
        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql -> execute();
    }
    
    if(!empty($_POST["deletenumber"])&&($_POST["password"])=="candyapple"){
        $id=$_POST["deletenumber"];
        $sql = 'delete from keijiban where id=:id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();}
    
    if(!empty($_POST["editnumber"])&&($_POST["password"])=="candyapple"){
        $editnumber=$_POST["editnumber"];
        $hensyunumber=$_POST["editnumber"];
        $sql = "SELECT * FROM keijiban WHERE id=$editnumber ";
        $stmt = $pdo->query($sql);
        foreach ($stmt as $row) {
            $namae = $row['name'];
            $komento = $row['comment'];}}
            
    if(!empty($_POST["hensyunumber"])&&($_POST["password"])=="candyapple"){
        $id=$_POST["hensyunumber"];
        $name=$_POST["name"];
        $comment=$_POST["comment"];
        $sql = 'UPDATE keijiban SET name=:name,comment=:comment WHERE id=:id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();}
?>

<html>
　<head>
　  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
　</head>
　<body>
　    <form  method="POST" action="">
　        <input type="text" name="name" value="<?php echo $namae ; ?>">
　        <input type="text" name="comment" value="<?php echo $komento ; ?>">
　        <input type="text" name="password" value="パスワード">
　        <input type="text" name="hensyunumber"  value="<?php if(!empty($hensyunumber)){echo $hensyunumber ;} ?>"" >
　        <input type="submit" value="送信">
　    </form>
　    <form  method="POST" action="" >
　        <input type="number" name="deletenumber" value="削除対象番号">
　        <input type="text" name="password" value="パスワード">
　        <input type="submit" value="削除" >
　    </form>
　    <form  method="POST"  action="" >
　        <input type="number" name="editnumber" value="編集対象番号">
　        <input type="text" name="password" value="パスワード">
　        <input type="submit" value="編集" >
　    </form>
　    <?php $sql = 'SELECT * FROM keijiban';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['comment'].'<br>';
                echo "<hr>";
    }?>
    </body>
</html>