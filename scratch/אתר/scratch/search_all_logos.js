const fs = require('fs');
const path = require('path');
const dir = 'c:\\Users\\User\\Desktop\\ATAR MCHSUV\\אתר';

fs.readdirSync(dir).forEach(file => {
    if (file.endsWith('.html')) {
        const content = fs.readFileSync(path.join(dir, file), 'utf8');
        if (content.includes('לוגו') || content.includes('logo')) {
            console.log(`Found in: ${file}`);
        }
    }
});
