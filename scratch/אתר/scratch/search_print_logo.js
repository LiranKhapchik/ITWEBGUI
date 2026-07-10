const fs = require('fs');
const content = fs.readFileSync('c:\\Users\\User\\Desktop\\ATAR MCHSUV\\אתר\\דשבורד.html', 'utf8');

const lines = content.split('\n');
lines.forEach((line, idx) => {
    if (line.includes('סימוכין') || line.includes('logo') || line.includes('לוגו') || line.includes('print')) {
        console.log(`${idx + 1}: ${line.trim()}`);
    }
});
