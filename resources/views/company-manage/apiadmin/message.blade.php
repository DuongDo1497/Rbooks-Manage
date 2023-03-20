<html>
<head>
    <meta charset="UTF-8" />
    <title>RBOOKS.HR</title>
    <style>
        a {
            font-family: Verdana, Arial, Helvetica;
            font-size: 12px;
            font-weight: normal;
            text-decoration: none;
            color: #0000FF;
        }
        
        a:hover {
            color: #0000AA;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    
<table width="100%" style="margin-top:20px;" cellpadding=1 cellspacing=1>
    <tr>
        <td align="center">
            <div class="alert alert-success" style="max-width:450px; background-color:whitesmoke"><br>
                <font size=4 color='#3c7660' style="font-weight:bold">{{ $infor }}</font>
                        <font color='#3c7660'><p>Xét duyệt Nghỉ: {{ $employeename }}</p></font>
                <div style="text-align:center; padding-top:10px;"><a href="{{ route('dashboard') }}"><font color='#4291ef'>Quay lại trang chủ</font></a></div>
                <br>
            </div>
        </td>
    </tr>
</table>
</body>
</html>



