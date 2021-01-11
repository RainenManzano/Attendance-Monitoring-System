    <div class="container-fluid" id="container">
        <div class="col-md-6">
            <div id="barcode-scanner">
                <video src=""></video>
                <canvas class="drawingBuffer"></canvas>
            </div>                
        </div>
        
        <div class="col-md-6">
            <section>
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-question-circle fa-lg"></i> Information</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="picture col-md-6">
                            <img id="picture" class="picture" src="<?php echo base_url('assets/pictures/person.png');?>">
                        </div>
                        
                        <div class="info col-md-6">
                            <h4>Student Number: </h4>
                            <span id="studNum">----------------------------------------</span>
                            <br><br>
                            <h4>Name: </h4>
                            <span id="name"">----------------------------------------</span>
                            <br><br>
                            <h4>Course & Section </h4>
                            <span id="course"">----------------------------------------</span>
                            <br><br>
                            <h4>Time in </h4>
                            <span id="timein"">----------------------------------------</span>
                            <br>                      
                        </div>
                    </div>
                    
                </div>
            </div>

            </section>    
            <center><h4 id="status">Barcode Scanner Ready</h4></center>
        </div>

    </div>
    
</body>
<script src="<?php echo base_url('assets/js/base_url.js');?>"></script>
<script src="<?php echo base_url('assets/libraries/serratus-quaggaJS-v0.12.1-12-ge96eb9f/dist/quagga.min.js'); ?>"></script>
<script>

    $(document).ready(function() {

        var classId = location.hash.substr(1);

        if(navigator.mediaDevices && typeof navigator.mediaDevices.getUserMedia === "function") {
            Quagga.init({
                inputStream : {
                    name : "Live",
                    type : "LiveStream",
                    target: document.querySelector('#barcode-scanner')    // Or '#yourElement' (optional)
                },
                decoder : {
                    readers : ["code_128_reader"]
                }
            }, function(err) {
                    if (err) {
                        console.log(err);
                        return
                    }
                    console.log("Initialization finished. Ready to start");
                    Quagga.start();
            });

            enableBarcodeScanner();

        }

        function enableBarcodeScanner() {
            Quagga.onDetected(function(result) {
                var scannedStudent = result.codeResult.code;
                console.log(scannedStudent)
                Quagga.offDetected();
                $.ajax({
                    url: base_url+"attendance/Get_Info_Student",
                    method: "POST",
                    data: {
                        "id": scannedStudent,
                        "class_id": classId
                    },
                    dataType: "JSON",
                    beforeSend: function() {
                        document.getElementById("status").innerHTML = "Finding Match"
                    },
                    success: function(data) {
                        console.log(data);
                        document.getElementById("studNum").style.display = "none";
                        document.getElementById("name").style.display = "none";
                        document.getElementById("course").style.display = "none";
                        document.getElementById("timein").style.display = "none";
                        document.getElementById("picture").style.display = "none";
                        if(data.status=="none") {
                            document.getElementById("studNum").innerHTML = "----------------------------------------";
                            document.getElementById("name").innerHTML = "----------------------------------------";
                            document.getElementById("course").innerHTML = "----------------------------------------";
                            document.getElementById("timein").innerHTML = "----------------------------------------";
                            document.getElementById("picture").src = base_url+"assets/pictures/person.png";
                            document.getElementById("status").innerHTML = "No student found for this class"
                        } else {
                            document.getElementById("studNum").innerHTML = data.studentNum;
                            document.getElementById("name").innerHTML = data.name;
                            document.getElementById("course").innerHTML = data.sectionName;
                            document.getElementById("timein").innerHTML = data.Timein;
                            document.getElementById("picture").src = base_url+"assets/student_pictures/"+data.imagePath;
                            document.getElementById("status").innerHTML = "Successfully Timed In!"
                        }
                        $("#studNum").fadeIn(500);
                        $("#name").fadeIn(500);
                        $("#course").fadeIn(500);
                        $("#timein").fadeIn(500);
                        $("#picture").fadeIn(500);
                        setTimeout(function() {
                            console.log("Restarting");
                            document.getElementById("status").innerHTML = "Barcode Scanner Ready"
                            enableBarcodeScanner();
                        },2000)
                    },
                    error: function(err) {
                        console.log(err.responseText);
                    }
                })
            });
        }



    })
    

</script>
</html>