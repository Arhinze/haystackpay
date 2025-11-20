<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <button id="speakBtn">🎤 Speak</button>
<p id="transcript"></p>

<script>
    let recognition = new(window.SpeechRecognition || window.webkitSpeechRecognition)();
    recognition.lang = "en-US";
    recognition.continuous = false;
    
    document.getElementById("speakBtn").onclick = () => recognition.start();
    
    recognition.onresult = function(event) {
        let text = event.results[0][0].transcript;
        document.getElementById("transcript").textContent = text;
    
        // Send recognized text to PHP
        fetch("ai.php", {
            method: "POST",
            headers: {"Content-Type": "application/x-www-form-urlencoded"},
            body: "message=" + encodeURIComponent(text)
        })
        .then(res => res.json())
        .then(data => {
            alert("AI Response: " + data.choices[0].message.content);
        });
    };
</script>
</body>
</html>