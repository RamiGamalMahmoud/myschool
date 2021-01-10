cd ..\resources\backup\dev
mysqldump -u root myschool --routines --no-data --result-file=schema.sql
mysqldump -u root myschool --no-create-info --result-file=all-data.sql
mysqldump -u root myschool first_semester_evaluation --no-create-info --result-file=first_semester_evaluation.sql
mysqldump -u root myschool first_semester_practical --no-create-info --result-file=first_semester_practical.sql
mysqldump -u root myschool first_semester_written --no-create-info --result-file=first_semester_written.sql
mysqldump -u root myschool school_management_data --no-create-info --result-file=school_management_data.sql
mysqldump -u root myschool second_semester_evaluation --no-create-info --result-file=second_semester_evaluation.sql
mysqldump -u root myschool second_semester_practical --no-create-info --result-file=second_semester_practical.sql
mysqldump -u root myschool second_semester_written --no-create-info --result-file=second_semester_written.sql
mysqldump -u root myschool secret_numbers --no-create-info --result-file=secret_numbers.sql
mysqldump -u root myschool student_degrees --no-create-info --result-file=student_degrees.sql
mysqldump -u root myschool students_data --no-create-info --result-file=students_data.sql
mysqldump -u root myschool users --no-create-info --result-file=users.sql
cd ..\..\..\scripts