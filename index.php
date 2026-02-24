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
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">

<style>

body {
    margin:0;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    font-family:'Share Tech Mono', monospace;
    background: linear-gradient(-45deg, #0d1117, #001f1f, #002b36, #0d1117);
    background-size:400% 400%;
    animation: gradientBG 10s ease infinite;
    color:#00ffcc;
}

@keyframes gradientBG {
    0%{background-position:0% 50%;}
    50%{background-position:100% 50%;}
    100%{background-position:0% 50%;}
}

.container {
    width:550px;
    padding:35px;
    border-radius:15px;
    backdrop-filter: blur(15px);
    background: rgba(0,0,0,0.6);
    border:1px solid rgba(0,255,200,0.3);
    box-shadow:0 0 40px rgba(0,255,200,0.4);
    animation: fadeIn 1s ease-in-out;
}

@keyframes fadeIn {
    from {opacity:0; transform:translateY(20px);}
    to {opacity:1; transform:translateY(0);}
}

h2 {
    text-align:center;
    margin-bottom:25px;
    letter-spacing:2px;
}

input, select {
    width:100%;
    padding:10px;
    margin:12px 0;
    background:#0d1117;
    color:#00ffcc;
    border:1px solid #00ffcc;
    border-radius:6px;
    font-family:inherit;
    transition:0.3s;
}

input:focus, select:focus {
    outline:none;
    box-shadow:0 0 10px #00ffcc;
}

button {
    width:100%;
    padding:12px;
    margin-top:10px;
    background:#00ffcc;
    color:#000;
    border:none;
    border-radius:6px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

button:hover {
    background:#00ccaa;
    transform:scale(1.05);
}

.result {
    margin-top:20px;
    padding:15px;
    border-radius:8px;
    background:#0d1117;
    border:1px solid #00ffcc;
    min-height:40px;
    overflow:hidden;
    white-space:pre-wrap;
}

.cursor {
    display:inline-block;
    width:8px;
    background:#00ffcc;
    animation: blink 1s infinite;
}

@keyframes blink {
    0%{opacity:1;}
    50%{opacity:0;}
    100%{opacity:1;}
}

</style>
</head>

<body>

<div class="container">
    <h2>🔐 ENCRYPTION SYSTEM</h2>

    <form method="POST">
        <label>Enter Message:</label>
        <input type="text" name="message" required value="<?php echo htmlspecialchars($message); ?>">

        <label>Select Mode:</label>
        <select name="mode">
            <option value="encrypt" <?php if($mode=="encrypt") echo "selected"; ?>>Encrypt</option>
            <option value="decrypt" <?php if($mode=="decrypt") echo "selected"; ?>>Decrypt</option>
        </select>

        <button type="submit">EXECUTE</button>
    </form>

    <?php if ($output !== ""): ?>
        <div class="result">
            <span id="typedOutput"></span><span class="cursor"></span>
        </div>

        <script>
        const text = "<?php echo htmlspecialchars($output); ?>";
        let i = 0;
        function typeEffect() {
            if (i < text.length) {
                document.getElementById("typedOutput").innerHTML += text.charAt(i);
                i++;
                setTimeout(typeEffect, 40);
            }
        }
        typeEffect();
        </script>
    <?php endif; ?>

</div>

</body>
</html>
