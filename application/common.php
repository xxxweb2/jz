<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function sendEmail($toEmail, $msg)
{
//    $name = $this->input->post('name');
//    $email = $this->input->post('email');
    import('mailer.phpmailer', EXTEND_PATH, '.class.php');
    import('mailer.smtp', EXTEND_PATH, '.class.php');
//    require_once('mailer/phpmailer.class.php');
    $mail = new PHPMailer();                           //PHPMailer对象
    $mail->isSMTP();// 使用SMTP服务
    $mail->CharSet = "utf8";// 编码格式为utf8，不设置编码的话，中文会出现乱码
    $mail->Host = "smtp.163.com";// 发送方的SMTP服务器地址
    $mail->SMTPAuth = true;// 是否使用身份验证
    $mail->Username = "13221296662@163.com";// 发送方的163邮箱用户名
    $mail->Password = "xu9595";// 发送方的邮箱密码，注意用163邮箱这里填写的是“客户端授权密码”而不是邮箱的登录密码！

    $mail->Port = 25;// 163邮箱的ssl协议方式端口号是465/994
    $mail->From = "13221296662@163.com";
    $mail->Helo = "xxxx";
    $mail->setFrom("13221296662@163.com", "家政服务邮箱验证");// 设置发件人信息，如邮件格式说明中的发件人，这里会显示为Mailer(xxxx@163.com），Mailer是当做名字显示


    $mail->addAddress($toEmail, '');// 设置收件人信息，如邮件格式说明中的收件人，这里会显示为Liang(yyyy@163.com)
    $mail->IsHTML(true);
    $mail->Subject = '邮箱验证';// 邮件标题
    $mail->Body = $msg;// 邮件正文
//    $name = ltrim($name, '/');
//    $mail->AddAttachment($name);
    if (!$mail->send()) {// 发送邮件
        $return['code'] = 0;
    } else {
        $return['code'] = 1;
    }
    return $return;
}
