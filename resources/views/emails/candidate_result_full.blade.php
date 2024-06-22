<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
<div class="container">
    <p>Chào {{ $candidate->name }},</p>
    <br>
    <p>
			Phòng đã nhận được thông tin ứng tuyển của em. Tuy nhiên doanh nghiệp này đã tuyển đủ số lượng nhân sự.
    </p>
    <br>
    <p>
			Tiếp tục theo dõi thông báo tuyển dụng trên fanpage và Facebook của phòng. Nếu cảm thấy công việc phù hợp, em có thể gửi CV về email để phòng hỗ trợ em ứng tuyển với doanh nghiệp hoặc em có thể tiếp tục ứng tuyển các vị trí khác phù hợp trên trang web [BeeCareer](https://beecareer.poly.edu.vn/).
    </p>
    <br>
    <p>
        Ngoài ra, khi Phòng có thêm CV ứng tuyển phù hợp, em sẽ gửi sang thêm cho quý doanh xem xét.
    </p>
    <br>
    <p>
			Thân mến,
    </p>
    <p>
        Phòng QHDN.
    </p>
    <br>
    @include('emails.signature')
</div>
</body>

</html>
