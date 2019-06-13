<script src="js/materialize.min.js"></script>
<script>
    $(".btn").sideNav();

</script>
<script src="js/jquery-3.4.0.js"></script>
<script type="text/javascript">M.AutoInit();</script>
<script>
    $("#senha").on("focusout", function (e) {
        if ($(this).val() != $("#conf_senha").val()) {
            $("#conf_senha").removeClass("valid").addClass("invalid");
        } else {
            $("#conf_senha").removeClass("invalid").addClass("valid");
        }
    });

    $("#conf_senha").on("keyup", function (e) {
        if ($("#senha").val() != $(this).val()) {
            $(this).removeClass("valid").addClass("invalid");
        } else {
            $(this).removeClass("invalid").addClass("valid");
        }
    });
    var password = document.getElementById("senha"), confirm_password = document.getElementById("conf_senha");

    function validatePassword() {
        if (password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Passwords Don't Match");
        } else {
            confirm_password.setCustomValidity('');
        }
    }
    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;
</script>



<?php
$_SESSION['mensagem'] = NULL;
?>

<footer>
    <div class="page-footer red">
        <div class="footer-copyright red">
            <div class="text-lighten-5">
                <h6 style="text-align: left; margin:10px;">SGRD - Sistema de Gestão de Reembolso de Despesas</h6>
                <h6 style="text-align: left; margin:10px;">© <?php echo date('Y'); ?> - Uiliam Mello - Todos os direitos reservados</h6>
            </div>
        </div>
    </div>
</footer>
</body>
</html>