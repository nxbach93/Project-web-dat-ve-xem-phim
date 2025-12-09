<!DOCTYPE html>
<html>
    <body>
        <h1>Tài liệu học lập trình web</h1>
        <?php
            echo"<hr>";
        ?>
        <p>Tài liệu học HTML</p>
        <p>Tài liệu học CSS</p>
        <?php
            echo"<h2>Tài liệu học JavaScript</h2>";
            echo"<h3>Tài liệu học MySQL</h3>";
            echo"<h4>Tài liệu học PHP</h4>";
        ?>
        <hr>
        <?php
            $text= "Từ cơ bản"." "."đến nâng cao";
            echo $text;
        ?> 
        <br>
        <?php
            function showValue(){
                $a=5;            
                echo "Giá trị của a là: " . $a;
            }
            showValue();
        ?>
        <br>
        <?php
        $a = 1;
        $b = 2;
        function Sum(){
            global $a, $b;
            $b = $a + $b;
        }
        Sum();
        echo "Tổng 1 + 2 = " . $b;
        ?>
    </body>
</html>