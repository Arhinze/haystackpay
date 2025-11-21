<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<button id="start">Start Recording</button>
<button id="stop">Stop Recording</button>

<script>
let mediaRecorder;
let audioChunks = [];

document.getElementById("start").onclick = async () => {
    const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
    mediaRecorder = new MediaRecorder(stream);
    audioChunks = [];

    mediaRecorder.ondataavailable = e => audioChunks.push(e.data);
    mediaRecorder.start();
};

document.getElementById("stop").onclick = async () => {
    mediaRecorder.stop();

    mediaRecorder.onstop = async () => {
        const audioBlob = new Blob(audioChunks, { type: "audio/webm" });
        const formData = new FormData();
        formData.append("file", audioBlob, "audio.webm");

        const res = await fetch("process_audio.php", {
            method: "POST",
            body: formData
        });

        console.log(await res.text());
    };
};
</script>

</body>
</html>