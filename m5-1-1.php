    <?php
        $dsn = 'データベース名';
        $user = 'ユーザー名';
        $password = 'パスワード';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

        $sql = "CREATE TABLE IF NOT EXISTS tb2"
        ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "name char(32),"
        . "comment TEXT,"
        . "datetime TEXT,"
        . "password TEXT"
        .");";
        $stmt = $pdo->query($sql);
    
        $name = $_POST["name"];
        $comment=$_POST["comment"];
        $pass1=$_POST["pass1"];
        $number1=$_POST["number1"];
        $pass2=$_POST["pass2"];
        $number2=$_POST["number2"];
        $pass3=$_POST["pass3"];
        $number3=$_POST["number3"];
        $datetime=date("Y/m/d H:i:s");
        $value1="";
        $value2="";
    
        if(!empty($number2)&&!empty($pass3)){
            $sql = 'SELECT * FROM tb2';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row){
                if($row["id"]==$number2&&$row["password"]==$pass3){
                    $value1=$row["name"];
                    $value2=$row["comment"];
                }
            }
        }
    ?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset ="uft-8">
        <title>mission5-1</title>
    </head>
    
    <body>
        <form action="" method="post">
            
            【　投稿フォーム　】<br>
            名前：&emsp;&emsp;&emsp;&nbsp;<input type="text" name="name" value="<?php echo $value1; ?>"><br>
            コメント：&emsp;&nbsp;<input type="text" name="comment" value="<?php echo $value2; ?>"><br>
            パスワード：&nbsp;<input type="text" name="pass1">
            <input type="submit" value="送信"><br><br>
            <input type="hidden" name="number3" value="<?php if(!empty($number2)&&!empty($pass3)){$sql='SELECT * FROM tb2';$stmt=$pdo->query($sql);$results = $stmt->fetchAll();foreach ($results as $row){if($row["id"]==$number2&&$row["password"]==$pass3){echo $number2;}else{echo "";}}}?>"><br>
            
            【　削除フォーム　】<br>
            投稿番号：&emsp;&nbsp;<input type="number" name="number1"><br>
            パスワード：&nbsp;<input type="text" name="pass2"><br>
            <input type="submit" value="削除"><br><br><br>
            
            【　編集フォーム　】<br>
            投稿番号：&emsp;&nbsp;<input type="number" name="number2"><br>
            パスワード：&nbsp;<input type="text" name="pass3"><br>
            <input type="submit" value="編集"><br><br><br>
            
        </form>
    
        <?php
            if(empty($name)&&empty($comment)&&empty($number1)&&empty($number2)&&empty($number3)&&empty($pass1)&&empty($pass2)&&empty($pass3)){
                //何も入力がなかった場合
                echo "文字を入力してください"."<br>";
                $sql = 'SELECT * FROM tb2';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    echo $row['id'].',';
                    echo $row['name'].',';
                    echo $row['comment'].',';
                    echo $row['datetime'].'<br>';
                    echo "<hr>";
                }
                    
            }elseif(empty($name)&&empty($comment)&&!empty($number1)&&empty($number2)&&empty($number3)&&empty($pass1)&&!empty($pass2)&&empty($pass3)){        
                //削除対象番号とパスワード2が入力された場合 
                $a=0;//番号合ってて、パスワード合ってるかの確認
                $b=0;//番号合ってて、パスワード間違ってるの確認
                $c=0;//それ以外の確認
                $sql = 'SELECT * FROM tb2';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                //　↓テーブルの中身を調べる。
                foreach ($results as $row){
                    if($row["id"]==$number1){
                        if($row["password"]==$pass2){//番号合ってて、パスワード合ってる
                            $a=1;
                            $id = $number1;
                            $sql = 'delete from tb2 where id=:id';
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                            $stmt->execute();
                        }
                        else{//番号合ってて、パスワード間違ってる
                            $b=1;
                        }
                    }
                    else{
                        $c=1;
                    }
                }
                
                if($a==1&&$b==0){
                    echo "削除できました<br>";
                }elseif($a==0&&$b==1){
                    echo "パスワードが間違っています<br>";
                }elseif($a==0&&$b==0&&$c==1){
                    echo "入力された番号は存在しません<br>";
                }
                    
                $sql = 'SELECT * FROM tb2';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    echo $row['id'].',';
                    echo $row['name'].',';
                    echo $row['comment'].',';
                    echo $row['datetime'].'<br>';
                    echo "<hr>";
                }
                
            }elseif(empty($name)&&empty($comment)&&!empty($number1)&&empty($number2)&&empty($number3)&&empty($pass1)&&empty($pass2)&&empty($pass3)){    
            //削除対象番号のみ入力された場合
                echo "パスワードも入力してください<br>";
                $sql = 'SELECT * FROM tb2';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    echo $row['id'].',';
                    echo $row['name'].',';
                    echo $row['comment'].',';
                    echo $row['datetime'].'<br>';
                    echo "<hr>";
                }
                
            }elseif(empty($name)&&empty($comment)&&empty($number1)&&empty($number2)&&empty($number3)&&empty($pass1)&&!empty($pass2)&&empty($pass3)){    
            //パスワード2のみ入力された場合
                echo "削除対象番号も入力してください<br>";
                $sql = 'SELECT * FROM tb2';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    echo $row['id'].',';
                    echo $row['name'].',';
                    echo $row['comment'].',';
                    echo $row['datetime'].'<br>';
                    echo "<hr>";
                }
                
            }elseif(empty($name)&&empty($comment)&&empty($number1)&&!empty($number2)&&empty($number3)&&empty($pass1)&&empty($pass2)&&!empty($pass3)){
            //編集対象番号とパスワード3が入力された場合
                $a=0;//番号合ってて、パスワード合ってるかの確認
                $b=0;//番号合ってて、パスワード間違ってるの確認
                $c=0;//それ以外の確認
                $sql = 'SELECT * FROM tb2';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                //　↓テーブルの中身を調べる。
                foreach ($results as $row){
                    if($row["id"]==$number2){
                        if($row["password"]==$pass3){//番号合ってて、パスワード合ってる
                            $a=1;
                        }
                        else{//番号合ってて、パスワード間違ってる
                            $b=1;
                        }
                    }
                    else{
                        $c=1;
                    }
                }
                
                if($a==1&&$b==0){
                    echo "投稿フォームで編集してください<br>";
                }elseif($a==0&&$b==1){
                    echo "パスワードが間違っています<br>";
                }elseif($a==0&&$b==0&&$c==1){
                    echo "入力された番号は存在しません<br>";
                }
                    
                $sql = 'SELECT * FROM tb2';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    echo $row['id'].',';
                    echo $row['name'].',';
                    echo $row['comment'].',';
                    echo $row['datetime'].'<br>';
                    echo "<hr>";
                }
            }elseif(empty($name)&&empty($comment)&&empty($number1)&&!empty($number2)&&empty($number3)&&empty($pass1)&&empty($pass2)&&empty($pass3)){
             //編集対象番号のみ入力された場合
            echo "パスワードも入力してください<br>";
                $sql = 'SELECT * FROM tb2';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    echo $row['id'].',';
                    echo $row['name'].',';
                    echo $row['comment'].',';
                    echo $row['datetime'].'<br>';
                    echo "<hr>";
                }
                
            }elseif(empty($name)&&empty($comment)&&empty($number1)&&empty($number2)&&empty($number3)&&empty($pass1)&&empty($pass2)&&!empty($pass3)){
            //パスワード3のみ入力された場合
                echo "編集対象番号も入力してください<br>";
                $sql = 'SELECT * FROM tb2';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    echo $row['id'].',';
                    echo $row['name'].',';
                    echo $row['comment'].',';
                    echo $row['datetime'].'<br>';
                    echo "<hr>";
                }
                
            }elseif(!empty($name)&&!empty($comment)&&empty($number1)&&empty($number2)&&empty($number3)&&!empty($pass1)&&empty($pass2)&&empty($pass3)){
            //名前とコメントとパスワード1が入力された場合    
                $sql = $pdo -> prepare("INSERT INTO tb2 (name, comment,datetime,password) VALUES (:name, :comment,:datetime,:password)");
                $sql -> bindParam(':name', $name, PDO::PARAM_STR);
                $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
                $sql -> bindParam(':datetime', $datetime, PDO::PARAM_STR);
                $sql -> bindParam(':password', $pass1, PDO::PARAM_STR);
                $sql -> execute();
                
                $sql = 'SELECT * FROM tb2';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    echo $row['id'].',';
                    echo $row['name'].',';
                    echo $row['comment'].',';
                    echo $row['datetime'].'<br>';
                    echo "<hr>";
                }
            
            }elseif(!empty($name)&&empty($comment)&&empty($number1)&&empty($number2)&&empty($number3)&&!empty($pass1)&&empty($pass2)&&empty($pass3)){
            //名前とパスワード1が入力された場合 
                echo "コメントも入力してください<br>";
                $sql = 'SELECT * FROM tb2';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    echo $row['id'].',';
                    echo $row['name'].',';
                    echo $row['comment'].',';
                    echo $row['datetime'].'<br>';
                    echo "<hr>";
                }
                
            }elseif(empty($name)&&!empty($comment)&&empty($number1)&&empty($number2)&&empty($number3)&&!empty($pass1)&&empty($pass2)&&empty($pass3)){    
            //コメントとパスワード1が入力された場合
                echo "名前も入力してください<br>";
                $sql = 'SELECT * FROM tb2';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    echo $row['id'].',';
                    echo $row['name'].',';
                    echo $row['comment'].',';
                    echo $row['datetime'].'<br>';
                    echo "<hr>";
                }
                
            }elseif(!empty($name)&&!empty($comment)&&empty($number1)&&empty($number2)&&empty($number3)&&empty($pass1)&&empty($pass2)&&empty($pass3)){
            //名前とコメントが入力された場合    
                echo "パスワードも入力してください<br>";
                $sql = 'SELECT * FROM tb2';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    echo $row['id'].',';
                    echo $row['name'].',';
                    echo $row['comment'].',';
                    echo $row['datetime'].'<br>';
                    echo "<hr>";
                }
            
            }elseif(!empty($name)&&empty($comment)&&empty($number1)&&empty($number2)&&empty($number3)&&empty($pass1)&&empty($pass2)&&empty($pass3)){
            //名前のみ入力された場合 
                echo "コメントとパスワードも入力してください<br>";
                $sql = 'SELECT * FROM tb2';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    echo $row['id'].',';
                    echo $row['name'].',';
                    echo $row['comment'].',';
                    echo $row['datetime'].'<br>';
                    echo "<hr>";
                }
            
            }elseif(empty($name)&&!empty($comment)&&empty($number1)&&empty($number2)&&empty($number3)&&empty($pass1)&&empty($pass2)&&empty($pass3)){    
            //コメントのみ入力された場合
                echo "名前とパスワードも入力してください<br>";
                $sql = 'SELECT * FROM tb2';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    echo $row['id'].',';
                    echo $row['name'].',';
                    echo $row['comment'].',';
                    echo $row['datetime'].'<br>';
                    echo "<hr>";
                }
            
            
            //名前のみ入力された場合 
                echo "コメントとパスワードも入力してください<br>";
                $sql = 'SELECT * FROM tb2';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    echo $row['id'].',';
                    echo $row['name'].',';
                    echo $row['comment'].',';
                    echo $row['datetime'].'<br>';
                    echo "<hr>";
                }
            
            }elseif(empty($name)&&empty($comment)&&empty($number1)&&empty($number2)&&empty($number3)&&!empty($pass1)&&empty($pass2)&&empty($pass3)){    
            //パスワードのみ入力された場合
                echo "名前とコメントも入力してください<br>";
                $sql = 'SELECT * FROM tb2';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    echo $row['id'].',';
                    echo $row['name'].',';
                    echo $row['comment'].',';
                    echo $row['datetime'].'<br>';
                    echo "<hr>";
                }
                
            }elseif(!empty($name)&&!empty($comment)&&empty($number1)&&empty($number2)&&!empty($number3)&&!empty($pass1)&&empty($pass2)&&empty($pass3)){
            //$number3が空でなく名前とコメントとパスワード1が入力された場合      
                $sql = 'SELECT * FROM tb2';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    if($row["id"]==$number3){
                        if($row["password"]==$pass1){
                            $id = $number3;
                            $sql = 'UPDATE tb2 SET name=:name,comment=:comment,datetime=:datetime WHERE id=:id';
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                            $stmt->bindParam(':datetime', $datetime, PDO::PARAM_STR);
                            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                            $stmt->execute();
                            $a=1;
                        }else{//番号合ってて、パスワード間違ってる
                            $b=1;
                        }
                    }else{
                        $c=1;
                    }
                }
                
                if($a==1&&$b==0){
                    echo "編集できました<br>";
                }elseif($a==0&&$b==1){
                    echo "パスワードが間違っています<br>";
                }elseif($a==0&&$b==0&&$c==1){
                    echo "入力された番号は存在しません<br>";
                }
                    
                $sql = 'SELECT * FROM tb2';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    echo $row['id'].',';
                    echo $row['name'].',';
                    echo $row['comment'].',';
                    echo $row['datetime'].'<br>';
                    echo "<hr>";
                }
                        
            }else{
            //$number3が空でなく、名前とコメントとパスワードのいずれかもしくは両方に入力がされなかった場合      
                echo "もう一度編集対象番号を入力し、名前とコメント、パスワードを送信してください<br>"; 
                $sql = 'SELECT * FROM tb2';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    echo $row['id'].',';
                    echo $row['name'].',';
                    echo $row['comment'].',';
                    echo $row['datetime'].'<br>';
                    echo "<hr>";
                }
            }
            
        ?>
            
    </body>
</html>