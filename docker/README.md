# מדריך הרצה עם Docker ו-OpenShift

תיקייה זו מכילה את קובצי ההגדרה להרצת האתר בתוך קונטיינר Docker ובפריסה ל-OpenShift.

## הרצה מקומית באמצעות Docker

כדי לבנות ולהריץ את הקונטיינר מקומית, יש להריץ את הפקודות הבאות מהתיקייה הראשית של האתר (`אתר`):

### 1. בניית ה-Image:
```bash
docker build -f docker/Dockerfile -t military-portal:latest .
```

### 2. הרצת ה-Container:
```bash
docker run -d -p 8080:8080 --name military-portal-app military-portal:latest
```
האתר יהיה זמין בדפדפן בכתובת: `http://localhost:8080`

---

## פריסה ב-OpenShift

קובץ הפריסה `docker/openshift-deployment.yaml` מכיל את ההגדרות הבאות:
1. **PersistentVolumeClaim (PVC)**: שמירה קבועה של קובצי הנתונים בנפח של 1Gi.
2. **Deployment**: הגדרת הקונטיינר, הקצאת משאבים ומיפוי התיקייה `/opt/app-root/src/data` לדיסק הקבוע.
3. **Service**: חשיפת הפורט הפנימי 8080.
4. **Route**: יצירת כתובת רשת נגישה מחוץ לקלאסטר.

לפריסה מהירה בקלאסטר, הריצו:
```bash
oc apply -f docker/openshift-deployment.yaml
```
