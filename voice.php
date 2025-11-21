<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<button id="startBtn">Start Recording</button>
<button id="stopBtn">Stop</button>

<p id="output"></p>

<script>
let recorder;
let chunks = [];

navigator.mediaDevices.getUserMedia({ audio: true })
.then(stream => {
    recorder = new MediaRecorder(stream);

    recorder.ondataavailable = e => chunks.push(e.data);

    document.getElementById("startBtn").onclick = () => {
        chunks = [];
        recorder.start();
        document.getElementById("output").textContent = "Listening...";
    };

    document.getElementById("stopBtn").onclick = () => {
        recorder.stop();

        recorder.onstop = () => {
            let blob = new Blob(chunks, { type: "audio/webm" });
            let formData = new FormData();
            formData.append("audio", blob, "voice.webm");

            fetch("audio_to_ai.php", {
                method: "POST",
                body: formData
            })
            .then(async res => res.json())
            .then(data => {
                console.log(data);
                document.getElementById("output").textContent = data.text;
            })
            .catch(err => {
                console.error(err);
                document.getElementById("output").textContent = "Error";
            });
        };
    };
});
</script>

</body>
</html>