# README
### Woocommerce Manage Store

***
### Mục Tiêu
##### - Tạo ra một plugins giúp cho nhân viên có thể nhập số lượng tồn kho của các mặt hàng hiện có trong cửa hàng, và đồng thời chia chúng thành các nhóm dựa trên ngày nhập và ngày hết hạn. Từ đó giúp dễ dang cho việc quản lý số lượng của sản phẩm tồn kho 

***
### Công nghệ sử dụng
##### - Nền tảng phát triển: Wordpress có cài đặt Woocommerce
##### - Ngôn ngữ sử dụng lập trình và thiết kế giao diện:
    * PHP
    * Javascript
    * SQL
    * HTML
    * CSS

***
### Hướng dẫn cài đặt
  ##### - Nén plugins ***manage-store*** trong thư mục ***src*** thành file .zip hoặc file .tar.gz,...
  ##### - sau đó copy ***file.zip*** vừa nén ở bước trên vào thư mục ***wordpress/wp-content/plugins*** trên server
  ##### - giải nén ***file***
  ##### - tải lại trang wordpress
  ##### - vào trang ***Admin -> Plugins -> Active plugins Manage Store***
  
***
### Hướng dẫn sử dụng chi tiết 
   ##### - Mục ***Manage Store*** có:
      * Store: Mục quản lý/chỉnh sửa các kho được tạo
      * Add New Store: Thêm một kho mới
   ##### - Thêm một kho mới
      ##### Gồm có 2 mục chính là
         * Setting Info: nơi chứa các thông tin cơ bản của kho như: tên, địa chỉ, số điện thoại,...
         * Product Assign: Chứ thông tin về ngày nhập hàng, ngày hết hạn và số lượng của từng sản phẩm có trong kho.
   ##### - Gán sản phẩm cho một kho trong Order 
      ##### 1) Mục ***List Store*** chọn kho có chứa sản phẩm
      ##### 2) Ấn button ***Asign*** và hiển một popup điền số lượng sản phẩm muốn gán cho kho.
      ##### Sau khi ấn lưu Order thì xem lại thông tin tại mục ***Custom Fields*** > mục ***qty-assign-store***
  
