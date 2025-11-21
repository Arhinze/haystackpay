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
let recorder, chunks = [];

navigator.mediaDevices.getUserMedia({ audio: true })
.then(stream => {
    // Force proper, supported audio format
    recorder = new MediaRecorder(stream, {
        mimeType: "audio/webm;codecs=opus"
    });

    recorder.ondataavailable = e => chunks.push(e.data);

    document.getElementById("startBtn").onclick = () => {
        chunks = [];
        recorder.start();
        document.getElementById("output").textContent = "🎙️ Listening...";
    };

    document.getElementById("stopBtn").onclick = () => {
        recorder.stop();
        document.getElementById("output").textContent = "Processing...";
    };

    recorder.onstop = () => {
        let blob = new Blob(chunks, { type: "audio/webm" });

        let formData = new FormData();
        formData.append("audio", blob, "voice.webm");

        fetch("audio_to_ai.php", {
            method: "POST",
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            console.log("Groq Response:", data);
            document.getElementById("output").textContent = data.text || "No text returned.";
            document.getElementById("output").textContent = "";
        })
        .catch(err => {
            document.getElementById("output").textContent = "";
            document.getElementById("output").textContent = "Error: " + err;
        });
    };
});
</script>

</body>
</html>