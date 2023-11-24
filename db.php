<?php
class DB{
 

del('dept','33',['code'=>'110','name'=>'圖書系']);
function all($table = null, $where = '', $other = '')
{
    $dsn = "mysql:host=localhost;charset=utf8;dbname=school";
    $pdo = new PDO($dsn, 'root', '');

    $sql = "select * from `$table`";
   
    if (isset($table) && !empty($table)) {

        if (is_array($where)) {
            if (!empty($where)) {
                foreach ($where as $col => $value) {
                    $tmp[] = "`$col`='$value'";
                }
               
                $sql .= "where" .join("&&", $tmp);
            }
        } else {
            $sql .= "$where";
        }
        $sql .= $other;
        // $tmp[];
        // $sql = "select * from `$table`";
        //  $sql = "$a";
        // 
        print_r($sql); //檢查sql查詢有沒有錯誤失敗顯示出來
        $rows = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        return $rows;                     //PDO::FETCH_ASSOC減少顯示的欄位省流量大小
        // FETCH_NUM索引值      

    } else {
        echo "錯誤:沒有指定的資料表名稱";
    }
}
// -------------------------------------
// 查詢指定id只取一筆
function find($table, $id)
{
    $dsn = "mysql:host=localhost;charset=utf8;dbname=school";
    $pdo = new PDO($dsn, 'root', '');
    // $sql="select * from `$table` where `id` = '$id' ";
    $sql = "select * from `$table` ";
    if (!empty($id)) {
        foreach ($id as $col => $value) {
            $tmp[] = "`$col`='$value'";
        }
        $sql .= "where" . join(" && ", $tmp);
    } elseif (is_numeric($id)) {
        $sql .= " where `id`='$id' ";
    } else {
        echo "錯誤:參數的資料型態必須是數字或陣列";
    }
    echo 'find=>' . $sql;
    $row = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    return $row;
}
// -----------------------------
function update($table, $id, $cols){
    $dsn = "mysql:host=localhost;charset=utf8;dbname=school";
    $pdo = new PDO($dsn, 'root', '');
    $sql = "update `$table` set ";
    
    if (!empty($cols)) {
        foreach ($cols as $col => $value) {
            $tmp[] = "`$col`='$value'";
        }
    } else {
        echo "錯誤:缺少要編輯的欄位陣列";
    }
    $sql .= join(",",$tmp);
    $tmp = [];
    if (is_array($id)) {
        foreach ($id as $col => $value) {
            $tmp[] ="`$col`='$value'";
        }
        $sql .= " where " .join(" && ",$tmp);
    } elseif (is_numeric($id)){
        $sql .= " where `id`= '$id' ";
    } else {
        echo "錯誤:參數的資料型態必須是數字或陣列";
    } 
    echo $sql;
    return $pdo->exec($sql); //知道影響幾列
}
// ---------------------------------
function insert($table,$values ){
    $dsn = "mysql:host=localhost;charset=utf8;dbname=school";
    $pdo = new PDO($dsn, 'root', '');

    $sql = "insert into `$table`  ";
    $cols= "(`".join ("`,`",array_keys($values))."`)" ;
    $vals="('".join("','",$values)."')";
    $sql= $sql . $cols ."values".$vals;

    echo $sql;
    return $pdo->exec($sql);
}
// ---------------------------------
function pdo(){
    $dsn = "mysql:host=localhost;charset=utf8;dbname=school";
    $pdo = new PDO($dsn, 'root', '');
    return $pdo;
}
// -------------------------
function del($table, $id, ){
    // $dsn = "mysql:host=localhost;charset=utf8;dbname=school";
    // $pdo = new PDO($dsn, 'root', '');
    // include "pdo.php";
    $pdo=pdo();
    $sql = "delete from `$table` where  ";
    if (is_array($id)) {
        // foreach產生,欄,值
        foreach ($id as $col => $value) {
          // 將上組合的字串放到$tmp的陣列中 。這樣，$tmp 中存儲的是轉換後的每個刪除條件
            $tmp[] = "`$col`='$value'";//   例如 ["欄位1='值1'", "欄位2='值2'", ...]。
        }
        $sql .= join(" && ", $tmp);
    } elseif (is_numeric($id)) {
        $sql .= " `id`='$id' ";
    } else {
        echo "錯誤:參數的資料型態必須是數字或陣列";
    }
    echo $sql;
    return $pdo->exec($sql);
}
// ---------------------
//自定義印出來函式 
function dd($array) //dd簡單取名direct dump直接印
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

}





?>