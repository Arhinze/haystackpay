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

// Request microphone
navigator.mediaDevices.getUserMedia({ audio: true })
.then(stream => {
    // WAV works everywhere, so we use default browser encoding
    recorder = new MediaRecorder(stream);

    recorder.ondataavailable = e => chunks.push(e.data);

    document.getElementById("startBtn").onclick = () => {
        chunks = [];
        recorder.start();
        document.getElementById("output").innerHTML = "🎙️ Listening...";
    };

    document.getElementById("stopBtn").onclick = () => {
        recorder.stop();
        document.getElementById("output").innerHTML = "Processing...";
    };

    recorder.onstop = () => {
        let blob = new Blob(chunks, { type: "audio/wav" });

        let formData = new FormData();
        formData.append("audio", blob, "voice.wav");

        fetch("audio_to_ai.php", {
            method: "POST",
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            console.log(data);
            document.getElementById("output").textContent = data.text || "No text returned.";
            document.getElementById("output").innerHTML = "";
        })
        .catch(err => {
            document.getElementById("output").textContent = "Error: " + err;
            document.getElementById("output").innerHTML = "";
        });
    };
})
.catch(err => {
    alert("Microphone access denied: " + err);
});
</script>

</body>
</html>