# שימוש באימג' הרשמי של Red Hat UBI 9 המותאם ל-PHP 8.1
# אימג' זה רץ כברירת מחדל כמשתמש שאינו root ומאזין על פורט 8080 (מתאים ל-OpenShift)
FROM registry.access.redhat.com/ubi9/php-81:latest

# העתקת כל קבצי האתר לתיקיית העבודה של השרת
COPY --chown=1001:0 . /opt/app-root/src/

# יצירת תיקיית data והגדרת הרשאות כתיבה לקבוצה 0 (הקבוצה שבה רץ המשתמש האקראי ב-OpenShift)
RUN mkdir -p /opt/app-root/src/data && \
    chmod -R g+rwX /opt/app-root/src/data && \
    chgrp -R 0 /opt/app-root/src/data

# חשיפת הפורט הפנימי של Apache (פורט 8080 ולא פורט 80, עקב מגבלות Non-root)
EXPOSE 8080

# הפעלת שרת ה-Apache
CMD ["container-entrypoint", "/usr/libexec/s2i/run"]
