const tiktoken = require('tiktoken');
const fs = require('fs');


const [, , ...args] = process.argv;

/* args syntax
-m <model> 
-f <file> 
-t <text>
-e
-d
*/

//parse arguments, order may vary
let model, file, encoding, decoding, text;
for (let i = 0; i < args.length; i++) {
    if (args[i] === "-m") {
        model = args[i + 1];
    } else if (args[i] === "-f") {
        file = args[i + 1];
    } else if (args[i] === "-t") {
        text = args[i + 1];
    } else if (args[i] === "-e") {
        encoding = args[i];
    } else if (args[i] === "-d") {
        decoding = args[i];
    }

}
try {
    const enc = tiktoken.encoding_for_model(model)
    let content = text;
    if (file) {
        content = fs.readFileSync(file, 'utf8');
    }


    if (encoding) {
        console.log(JSON.stringify(Array.from(enc.encode(content))));

        process.exit(0);
    }

    if (decoding) {
        console.log(String.fromCharCode.apply(null, enc.decode(JSON.parse(content))));
        process.exit(0);
    }

} catch (e) {
    console.error(e.message);
    process.exit(1);
}
