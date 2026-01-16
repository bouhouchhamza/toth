<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($course['title']); ?> - Thoth LMS</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .header { background: #007bff; color: white; padding: 20px 0; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .header-content { display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 24px; }
        .user-info { display: flex; align-items: center; gap: 15px; }
        .btn { padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-logout { background: #dc3545; color: white; }
        .btn-logout:hover { background: #c82333; }
        .btn-back { background: #6c757d; color: white; }
        .btn-back:hover { background: #5a6268; }
        .main { padding: 40px 0; }
        .course-detail { background: white; padding: 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .course-header { border-bottom: 1px solid #eee; padding-bottom: 20px; margin-bottom: 30px; }
        .course-title { font-size: 32px; color: #333; margin-bottom: 10px; }
        .course-description { font-size: 18px; line-height: 1.6; color: #666; }
        .enrollment-status { background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 4px; margin-bottom: 30px; }
        .not-enrolled { background: #f8d7da; border: 1px solid #f5c6cb; }
        .btn-enroll { background: #28a745; color: white; padding: 12px 24px; font-size: 16px; }
        .btn-enroll:hover { background: #218838; }
        .course-content { margin-top: 30px; }
        .course-content h3 { color: #333; margin-bottom: 15px; }
        .course-content p { color: #666; line-height: 1.6; }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-content">
                <h1>Thoth Learning Management System</h1>
                <div class="user-info">
                    <span><?php echo htmlspecialchars($student['name']); ?></span>
                    <a href="/logout" class="btn btn-logout">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <main class="main">
        <div class="container">
            <div class="course-detail">
                <div class="course-header">
                    <a href="/student/dashboard" class="btn btn-back">← Back to Dashboard</a>
                    <h1 class="course-title"><?php echo htmlspecialchars($course['title']); ?></h1>
                </div>

                <?php if ($isEnrolled): ?>
                    <div class="enrollment-status">
                        <h3>✓ You are enrolled in this course</h3>
                        <p>You have full access to all course materials and can track your progress.</p>
                    </div>
                <?php else: ?>
                    <div class="enrollment-status not-enrolled">
                        <h3>You are not enrolled in this course</h3>
                        <p>Enroll now to get access to course materials and start learning.</p>
                        <form method="POST" action="/student/enroll" style="margin-top: 15px;">
                            <input type="hidden" name="csrf_token" value="<?php echo \Auth::generateCSRFToken(); ?>">
                            <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                            <button type="submit" class="btn btn-enroll">Enroll in this Course</button>
                        </form>
                    </div>
                <?php endif; ?>

                <div class="course-content">
                    <h3>Course Description</h3>
                    <p><?php echo nl2br(htmlspecialchars($course['description'])); ?></p>
                </div>

                <?php if ($isEnrolled): ?>
                    <div class="course-content">
                        <h3>Course Materials</h3>
                        <p>This is where course materials, videos, and assignments would be displayed.</p>
                        <p>Course content management features can be added here.</p>
                    </div>

                    <div class="course-content">
                        <h3>Progress Tracking</h3>
                        <p>Your progress in this course will be tracked here.</p>
                        <p>Features like completion percentage, quiz scores, and certificates can be implemented.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>
