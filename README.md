## Xây dựng Repo có cấu trúc thư mục như sau:

- **Model.php**: Là base class kết nối và thực thi SQL
- Các thuộc tính: `$table`, `$select`, `$whereClause`, `$orderClause`, `$groupClause`, `$connection`
- Các phương thức: `connect()`, `query()`, `getFirst()`, `getAll()`, `get()`, `where()`, `orderBy()`, `groupBy()`
- **Staff.php**: Đối tượng nhân viên
- Các phương thức: `getSalary()`
- **ConvertSale.php**: Đối tượng nhân viên khối ConvertSale
- Công thức tính lương:
    - KPI: `100 link`
    - Lương cứng nếu đủ KPI: `6.000.000đ`
    - Thiếu KPI: `1 - 20` phạt `10.000đ/link`, `21 - 100` phạt `15.000d/link`
    - Thừa KPI: `15.000đ/link`
- **IT.php**: Đối tượng nhân viên khối IT
- Công thức tính lương:
    - Lương cứng: `8.000.000đ`
    - Thưởng: tùy tháng
- **index.php**: Thực thi lấy ra lương của 5 nhân viên trong tháng

## Yêu cầu

- Kết quả trả về một mảng các đối tượng 
- `getFirst()` trả về một đối tượng
- Add autoload project

**Note:** 
- Run `composer dump-autoload` to generate autoload file

## Final

```php
$its = IT::query()->where('bonus', '>', 0)->orderBy('bonus', 'desc')->getFirst();
$cvss = CVS::query()->select('name', 'salary', 'kpi')->where('kpi', '>', 100)->orderBy('kpi', 'desc')->getFirst();
```
