<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Thoth LMS</title>
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
        .main { padding: 40px 0; }
        .section { background: white; margin-bottom: 30px; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .section h2 { margin-bottom: 20px; color: #333; }
        .course-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
        .course-card { border: 1px solid #ddd; border-radius: 8px; padding: 20px; background: #f9f9f9; }
        .course-card h3 { color: #007bff; margin-bottom: 10px; }
        .course-card p { color: #666; margin-bottom: 15px; }
        .btn-enroll { background: #28a745; color: white; }
        .btn-enroll:hover { background: #218838; }
        .btn-view { background: #17a2b8; color: white; }
        .btn-view:hover { background: #138496; }
        .welcome { background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 4px; margin-bottom: 30px; }
        .no-courses { color: #666; font-style: italic; }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-content">
                <h1>Thoth Learning Management System</h1>
                <div class="user-info">
                    <span>Welcome, <?php echo htmlspecialchars($student['name']); ?>!</span>
                    <a href="/logout" class="btn btn-logout">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <main class="main">
        <div class="container">
            <div class="welcome">
                <h2>Welcome to your Dashboard</h2>
                <p>Manage your courses and track your learning progress.</p>
            </div>

            <section class="section">
                <h2>My Enrolled Courses</h2>
                <?php if (!empty($courses)): ?>
                    <div class="course-grid">
                        <?php foreach ($courses as $course): ?>
                            <div class="course-card">
                                <h3><?php echo htmlspecialchars($course['title']); ?></h3>
                                <p><?php echo htmlspecialchars($course['description']); ?></p>
                                <a href="/student/course/<?php echo $course['id']; ?>" class="btn btn-view">View Course</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="no-courses">You haven't enrolled in any courses yet.</p>
                <?php endif; ?>
            </section>

            <section class="section">
                <h2>Available Courses</h2>
                <?php if (!empty($availableCourses)): ?>
                    <div class="course-grid">
                        <?php foreach ($availableCourses as $course): ?>
                            <div class="course-card">
                                <h3><?php echo htmlspecialchars($course['title']); ?></h3>
                                <p><?php echo htmlspecialchars($course['description']); ?></p>
                                <form method="POST" action="/student/enroll" style="display: inline;">
                                    <input type="hidden" name="csrf_token" value="<?php echo \Auth::generateCSRFToken(); ?>">
                                    <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                    <button type="submit" class="btn btn-enroll">Enroll Now</button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="no-courses">No new courses available at the moment.</p>
                <?php endif; ?>
            </section>
        </div>
    </main>
</body>
</html>
