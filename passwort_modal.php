<?php include("includes/authentication.inc.php");?>

<div class="modal fade" id="passresetmodal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Passwort ändern</h4>
            </div>

            <div class="modal-body">
                <form id="modalform" role="form" action="" method="post">

                    <p class="alert alert-success" role="alert" id="feedback_positive"></p>
                    <p class="alert alert-warning" role="alert" id="feedback_negative"></p>

                    <div class="form-group">
                        <label for="oldpass">Aktuelles Passwort</label>
                        <input type="password" name="passold" id="passold" class="form-control" required="required" />
                    </div>

                    <div class="form-group">
                        <label for="newpass">Neues Passwort</label>
                        <input type="password" name="passnew" id="passnew" class="form-control" required="required" />
                    </div>

                    <div class="form-group">
                        <label for="newpass1">Neues Passwort bestätigen</label>
                        <input type="password" name="passnew1" id="passnew1" class="form-control" required="required" />
                    </div>

                    <button type="submit" name ="send" id="send" class="btn btn-primary">Passwort ändern</button>

                </form>
            </div>
        </div>
    </div>
</div>

<script id="source" language="javascript" type="text/javascript">

    $(document).ready(function() {
        $('#passreset').on('click', function(e) {
            $('#feedback_positive').hide();
            $('#feedback_negative').hide();
        });

        $('#send').on('click', function(e) {
            e.preventDefault();

            var Passold = $('#passold').val();
            var Passnew = $('#passnew').val();
            var Passnew1 = $('#passnew1').val();

            $.ajax({
                url:"process_password.php",
                type:"POST",
                dataType:"json",
                data:{Passold:Passold,Passnew:Passnew,Passnew1:Passnew1},

                success: function(response){

                        var status = response.flag;
                        if (status) {
                            $('#feedback_positive').show().html(response.message).delay(1000).fadeOut();
                            $('#passold').val("");
                            $('#passnew').val("");
                            $('#passnew1').val("");
                            $('#feedback_negative').hide();
                            $("#feedback_positive").promise().done(function() {

                                setTimeout(function(){

                                    $('#passresetmodal').modal('hide');

                                });
                            });
                        } else {
                            $('#feedback_negative').show().html(response.message);
                            $('#passresetmodal').effect("shake", {times: 2}, 500);
                        }
                }
            })
        });
    });

</script>