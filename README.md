# Simple Shop
Author: hungphongbk + anhvo
## Hướng dẫn thiết lập môi trường chạy thử
- Sau mỗi lần pull xuống, mở Command Prompt lên và chạy lần lượt các lệnh sau
    ```
    cd C:\xampp\htdocs\anhvo
    composer update
    composer start
    ```
    Lệnh cuối cùng để chạy demo, sau đó truy cập vào `http://localhost:8081/`
- Copy file `.env.example`, sửa tên file thành `.env`
- Trong file `.env`, sửa các biến sao cho phù hợp
    * `DB_NAME` - Tên cơ sở dữ liệu
    * `DB_USER` - Tài khoản đăng nhập vào mysql
    * `DB_PASSWORD` - Mật khẩu

### 02/10/2017