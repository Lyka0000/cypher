<?php

$encryptMap = [
    "A"=>"^","B"=>"3","C"=>"+","D"=>"?","E"=>"8","F"=>"A","G"=>"@",
    "H"=>"5","I"=>"$","J"=>"0","K"=>"4","L"=>"X","M"=>"%","N"=>"2",
    "O"=>"J","P"=>"*","Q"=>"B","R"=>"9","S"=>"G","T"=>"!","U"=>"C",
    "V"=>"6","W"=>"#","X"=>"I","Y"=>"1","Z"=>"7"
];

$decryptMap = array_flip($encryptMap);

function encryptMessage($text, $map) {
    $text = strtoupper($text);
    $result = "";
    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        $result .= isset($map[$char]) ? $map[$char] : $char;
    }
    return $result;
}

function decryptMessage($text, $map) {
    $result = "";
    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        $result .= isset($map[$char]) ? $map[$char] : $char;
    }
    return $result;
}

$message = $_POST["message"] ?? "";
$mode = $_POST["mode"] ?? "encrypt";
$output = "";

if ($message !== "") {
    $output = ($mode === "encrypt")
        ? encryptMessage($message, $encryptMap)
        : decryptMessage($message, $decryptMap);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Message Encryptor & Decryptor</title>

    <!-- Computer Style Font -->
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #0d1117;
            color: #00ff88;
            font-family: 'Share Tech Mono', monospace;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .terminal {
            background-color: #161b22;
            padding: 30px;
            width: 520px;
            border-radius: 10px;
            box-shadow: 0 0 25px #00ff88;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            background: #0d1117;
            color: #00ff88;
            border: 1px solid #00ff88;
            border-radius: 5px;
            font-family: inherit;
        }

        button {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            background: #00ff88;
            color: black;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #00cc6a;
        }

        .result {
            margin-top: 15px;
            padding: 10px;
            background: #0d1117;
            border: 1px solid #00ff88;
            border-radius: 5px;
            word-wrap: break-word;
        }

        .guide {
            margin-top: 15px;
            font-size: 14px;
            color: #8b949e;
            display: none;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: #161b22;
            padding: 25px;
            border: 1px solid #00ff88;
            width: 400px;
            color: #00ff88;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<div class="terminal">
    <h2>🔐 Message Encryptor & Decryptor</h2>

    <form method="POST">
        <label>Enter Message:</label>
        <input type="text" name="message" required>

        <label>Select Mode:</label>
        <select name="mode">
            <option value="encrypt">Encrypt</option>
            <option value="decrypt">Decrypt</option>
        </select>

        <button type="submit">Execute</button>
    </form>

    <?php if ($output !== ""): ?>
        <div class="result">
            OUTPUT: <?php echo htmlspecialchars($output); ?>
        </div>
    <?php endif; ?>

    <button onclick="toggleGuide()">📘 Show / Hide User Guide</button>
    <button onclick="openModal()">❓ Help</button>

    <div class="guide" id="guide">
        <h3>HOW TO USE THE SYSTEM</h3>

        <b>🟢 ENCRYPT:</b><br>
        1. Type your original message.<br>
        2. Select Encrypt mode.<br>
        3. Click Execute.<br>
        4. Copy the encrypted OUTPUT shown below.<br><br>

        <b>🔵 DECRYPT:</b><br>
        1. Copy the encrypted message.<br>
        2. Paste it into the message box.<br>
        3. Select Decrypt mode.<br>
        4. Click Execute.<br>
        5. The original message will appear.<br><br>

        ⚠ Decryption only works if the same substitution key was used.
    </div>
</div>

<!-- Modal -->
<div class="modal" id="modal">
    <div class="modal-content">
        <h3>System Instructions</h3>
        1. Enter message.<br>
        2. Choose Encrypt or Decrypt.<br>
        3. Click Execute.<br>
        4. To decrypt, paste encrypted text and switch to Decrypt mode.<br><br>
        <button onclick="closeModal()">Close</button>
    </div>
</div>

<script>
function toggleGuide() {
    var guide = document.getElementById("guide");
    guide.style.display = guide.style.display === "none" ? "block" : "none";
}

function openModal() {
    document.getElementById("modal").style.display = "flex";
}

function closeModal() {
    document.getElementById("modal").style.display = "none";
}
</script>

</body>
</html>