<?php
class Data{ 
    privateconn;
    private table = "data";

    public function __construct(db) {
        this->conn =db;
    }

    public function readAll() {
        stmt =this->conn->query("SELECT * FROM " . this->table);
        returnstmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(mac,datas, time_req){stmt = this->conn->prepare("INSERT INTO this->table(mac, datas, time_req) VALUES (?, ?, ?)");
        return stmt->execute([mac, datas,time_req]);
    }

    public function update(id,mac, datas,time_req) {
        stmt =this->conn->prepare("UPDATE this->table SET mac=?, datas=?, time_req=? WHERE id=?");
        returnstmt->execute([mac,datas, time_req,id]);
    }

    public function delete(id){
    stmt = this->conn->prepare("DELETE FROMthis->table WHERE id=?");
        return stmt->execute([id]);
    }
}
?>