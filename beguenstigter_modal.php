
<!-- Modal for new Recipient -->
<div class="modal fade" id="newRecipient" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Neuen Beg&uuml;nstigten erfassen</h4>
            </div>
            <div class="modal-body">
                <form id="modalForm" action="beguenstigter_modal.php" method="post">
                        <p class="alert alert-success" role="alert" id="feedback_positive"></p>
                    <p class="alert alert-warning" role="alert" id="feedback_negative"></p>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" id="name" class="form-control" />
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <label>Strasse</label>
                                    <input type="text" name="street" id="strasse" class="form-control"/>
                                </div>
                                <div class="col-md-4">
                                    <label>Hausnummer</label>
                                    <input type="text" name="housenumber" id="hausnummer" class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    <label>PLZ</label>
                                    <input type="number" name="plz" id="plz" class="form-control"/>
                                </div>
                                <div class="col-md-4">
                                    <label>Ort</label>
                                    <input type="text" name="town" id="ort" class="form-control"/>
                                </div>
                            </div>
                        </div>
                    </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
                <button type="submit" name ="send" id="send" class="btn btn-primary">Neuen Beg&uuml;nstigten anlegen</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#rec").on("click", function(e){
            $('#feedback_positive').hide();
            $('#feedback_negative').hide();

            $('#name').val("");
            $('#strasse').val("");
            $('#hausnummer').val("");
            $('#plz').val("");
            $('#ort').val("");
        });

        $("#send").on("click", function(e){
            e.preventDefault();

            // get values from textboxs
            var Name = $('#name').val();
            var Strasse = $('#strasse').val();
            var Hausnummer = $('#hausnummer').val();
            var PLZ = $('#plz').val();
            var Ort = $('#ort').val();


            $.ajax({
                url:"process.php",
                type:"POST",
                dataType:"json",
                data:{type:"claim",Name:Name,Strasse:Strasse,Hausnummer:Hausnummer, PLZ:PLZ, Ort:Ort},

                ContentType:"application/json",
                success: function(response){
                    var status = response.flag;
                    if(status==true){
                        $('#feedback_positive').show().html(response.message).delay(2000).fadeOut();
                        $('#name').val("");
                        $('#strasse').val("");
                        $('#hausnummer').val("");
                        $('#plz').val("");
                        $('#ort').val("");
                    }else {
                        $('#feedback_negative').show().html(response.message);
                        $('#newRecipient').effect( "shake", {times:4}, 1000 );
                        var Name = $('#name').val();
                        var Strasse = $('#strasse').val();
                        var Hausnummer = $('#hausnummer').val();
                        var PLZ = $('#plz').val();
                        var Ort = $('#ort').val();
                    }
                },
                error: function(err){
                    alert(JSON.stringify(err));
                }
            })
        });
    });

</script>