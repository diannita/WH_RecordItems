<footer>
    <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
    
    <script>
    // Empty the textarea completely
        function eraseText() {
            document.getElementById("output").value = "";
        }
                    
    // This javascript method is quite easy and blocks the pop up asking for form resubmission on refresh once the form is submitted
        if ( window.history.replaceState ) {
                window.history.replaceState( null, null, window.location.href );
        }

    // This jquery removes all tabs, spaces that we dont need 
        $(document).ready(function () {
            $('#output').focusout(function () {
                var text = $('#output').val();
                text = text.replace(/(?:(?:\r\n|\r|\n)\s*){2}/gm, "");
                $(this).val(text);
            });
        });

    //This function deletes the last item inside the textarea
        function delete_last_value() {
        var lines = $('#output').val().split('\n');
            $("#output").val(lines.slice(0, -2).join('\n') + "\r\n");
        }

    //Select list that shows warehouse and product from respective owner
        $(document).ready(function(e){
            $('#dropdown_owner').change(function(){
                $.ajax({
                    type:"POST",
                    url:"Queries/select_data.php",
                    data:"owner=" + $('#dropdown_owner').val(),
                    beforeSend: function () { },
                    success:function(owner){
                        $('#select_list').html(owner);
                    }
                });
            });
        }) 
         
    </script>

    <!-- This script counts the number of lines of the textarea -->
    <script>
        const textarea = document.querySelector('textarea')
            textarea.addEventListener('input', () => {
            const text = textarea.value;
            const lines = text.split("\n");
            const count = lines.length - 1;
            document.getElementById("lines").innerHTML = "Quantity <strong>" + count + "</strong>";
        })
    </script>
</footer>
