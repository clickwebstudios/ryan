<style>
    p{
        font-size: 16px;
        line-height: 20px;
    }
    .btn-orange{
        background: #FCB150;
        padding: 10px 25px;
        text-decoration: none;
        display: inline-block;
        margin: 15px 0;
        color: #000;
        font-size: 12px;
        font-weight: 700;
    }
    .btn-orange:hover{
        color: #000;
    }
    .link{
        color: rgb(0, 159, 167);
        font-weight: 700;
    }
    .email-table{
        text-align: center;
        position: relative;
    }
    .table-link{
        text-indent: -9999px;
        position: absolute;
        bottom: 20px;
        width: 300px;
        height: 50px;
        display: inline-block;
    }
    ul li{
        font-size: 14px;
    }
</style>
<table border="0" cellpadding="0" cellspacing="0" width="624" style="margin:auto;">
	<tbody>
		<tr>
			<td style="width:624px;height:28px;">
                <a style="color:rgb(3,169,178); text-decoration:underline"
                   href="<?php echo $siteUrl?>/?resultPrint=<?php echo $data['token']?>">
        <img
          src="<?php echo $siteUrl?>/wp-content/plugins/user-answers-form/dist/img/email-banner.jpg"
          width="100%"
        /></a><br />
                <p>Hello <?php echo $data['first_name']?>,</p>
                <p>I hope your mindset assessment results help you deepen your self-awareness of your current mental wiring.</p>
                <p>If you found you have some mindsets that could use some polishing, you are normal. Only 2.5% are in the top quartile for all four sets of mindsets. Thus, most of us have room to improve our mindsets.</p>
                <p>If you would like to work on upgrading your mindsets to elevate your thinking, learning, and behavior (really,your BEING), I have put together three different options that will help you (1) improve your knowledge and understanding of mindsets, and (2) develop and execute on a personal mindset development plan designed to elevate your life, career, and leadership:</p>
                <div class="email-table">
                    <a href="https://mindsetlibrary.ryangottfredson.com">
                        <img src="<?php echo $siteUrl?>/wp-content/plugins/user-answers-form/dist/img/email-table.png" alt="">
                    </a>
                </div>
                <p>You can also start by diving into my two books:</p>
                <div style="text-align:center;">
                    <img src="<?php echo $siteUrl?>/wp-content/plugins/user-answers-form/dist/img/email-books.png" alt="">
                    <p>
                        <a class="btn btn-orange" href="https://ryangottfredson.com/books">See Ryan's Books</a>
                    </p>
                </div>
                <p>You are at the start of a deep and transformational personal development journey.</p>
                <p>Thank you for letting me be a part of it.</p>
                <p><strong>Ryan Gottfredson</strong><br>
                    <a class="link" href="https://ryangottfredson.com">https://ryangottfredson.com/</a>
                </p>
                <div style="text-align:center;">
                <img src="<?php echo $siteUrl?>/wp-content/plugins/user-answers-form/dist/img/email-footer.jpg" width="100%" alt="">
                </div>
			</td>
		</tr>
	</tbody>
</table>
