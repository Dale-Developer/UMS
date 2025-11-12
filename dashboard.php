<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link
      href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="styles/dashboard.css" />
    <style>
      .recent-users {
        padding: 0;
        max-height: 300px;
        overflow-y: auto;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
      }
      
      .recent-user-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 16px;
        border-bottom: 1px solid #eee;
        transition: background-color 0.2s;
      }
      
      .recent-user-item:hover {
        background-color: #f8f9fa;
      }
      
      .recent-user-item:last-child {
        border-bottom: none;
      }
      
      .user-info {
        flex: 1;
      }
      
      .user-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 4px;
      }
      
      .user-email {
        font-size: 0.875rem;
        color: #666;
      }
      
      .user-date {
        font-size: 0.875rem;
        color: #888;
        white-space: nowrap;
      }
      
      .activity-list {
        padding: 0;
        max-height: 300px;
        overflow-y: auto;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
      }
      
      .activity-item {
        display: flex;
        align-items: flex-start;
        padding: 12px 16px;
        border-bottom: 1px solid #eee;
      }
      
      .activity-item:last-child {
        border-bottom: none;
      }
      
      .activity-icon {
        margin-right: 12px;
        margin-top: 2px;
      }
      
      .activity-details {
        flex: 1;
      }
      
      .activity-title {
        font-weight: 600;
        color: #333;
        margin-bottom: 4px;
      }
      
      .activity-description {
        font-size: 0.875rem;
        color: #666;
        margin-bottom: 4px;
      }
      
      .activity-time {
        font-size: 0.75rem;
        color: #888;
      }
      
      .no-data {
        text-align: center;
        padding: 40px 20px;
        color: #666;
        font-style: italic;
      }
      
      .chart-header {
        border-bottom: 1px solid #eee;
        padding-bottom: 16px;
        margin-bottom: 16px;
      }
      
      .chart-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
      }

      /* Custom scrollbar styles */
      .recent-users::-webkit-scrollbar,
      .activity-list::-webkit-scrollbar {
        width: 6px;
      }

      .recent-users::-webkit-scrollbar-track,
      .activity-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 0 8px 8px 0;
      }

      .recent-users::-webkit-scrollbar-thumb,
      .activity-list::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
      }

      .recent-users::-webkit-scrollbar-thumb:hover,
      .activity-list::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
      }
    </style>
  </head>
  <body>
    <!-- SIDEBAR -->
    <?php include 'sidebar.php'; ?>
    
    <!-- Page Header -->
    <div class="page-header">
      <h1 class="page-title">Dashboard</h1>
    </div>
    
    <!-- Dashboard Content -->
    <div class="stats-container">
      <div class="dashboard-layout">
        <div class="stats-grid">
          <?php
          include 'db_connect.php';
          
          // Get total users (all users in the table)
          $total_sql = "SELECT COUNT(*) as total FROM users";
          $total_result = $conn->query($total_sql);
          $total_users = $total_result->fetch_assoc()['total'];
          
          $active_users = $total_users;
          
         
          $deleted_users = 0;
          ?>
          
          <div class="stat-card total">
            <div class="stat-header">
              <div>
                <div class="stat-title">Total Users</div>
                <div class="stat-value"><?php echo $total_users; ?></div>
              </div>
              <div class="stat-icon">
                <i class="bx bxs-bar-chart-alt-2"></i>
              </div>
            </div>
          </div>

          <div class="stat-card active">
            <div class="stat-header">
              <div>
                <div class="stat-title">Active Users</div>
                <div class="stat-value"><?php echo $active_users; ?></div>
              </div>
              <div class="stat-icon">
                <i class="bx bx-run"></i>
              </div>
            </div>
          </div>

          <div class="stat-card delete">
            <div class="stat-header">
              <div>
                <div class="stat-title">Deleted Users</div>
                <div class="stat-value"><?php echo $deleted_users; ?></div>
              </div>
              <div class="stat-icon">
                <i class="bx bxs-trash"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="charts-grid">
          <!-- Recently Created Users -->
          <div class="chart-card">
            <div class="chart-header">
              <div class="chart-title">Recently Created Users</div>
            </div>
            <div class="recent-users">
              <?php
              // Get recently created users (last 5)
              $recent_sql = "SELECT username, email, date_created FROM users 
                            ORDER BY date_created DESC LIMIT 5";
              $recent_result = $conn->query($recent_sql);
              
              if ($recent_result->num_rows > 0) {
                while($user = $recent_result->fetch_assoc()) {
                  echo '<div class="recent-user-item">';
                  echo '<div class="user-info">';
                  echo '<div class="user-name">' . htmlspecialchars($user['username']) . '</div>';
                  echo '<div class="user-email">' . htmlspecialchars($user['email']) . '</div>';
                  echo '</div>';
                  echo '<div class="user-date">' . date('M j, Y', strtotime($user['date_created'])) . '</div>';
                  echo '</div>';
                }
              } else {
                echo '<div class="no-data">No users found</div>';
              }
              ?>
            </div>
          </div>

          <!-- User Activities -->
          <div class="chart-card">
            <div class="chart-header">
              <div class="chart-title">Recent Activities</div>
            </div>
            <div class="activity-list">
              <?php
              $activities_sql = "SELECT username, date_created FROM users 
                               ORDER BY date_created DESC LIMIT 6";
              $activities_result = $conn->query($activities_sql);
              
              if ($activities_result->num_rows > 0) {
                while($activity = $activities_result->fetch_assoc()) {
                  echo '<div class="activity-item">';
                  echo '<div class="activity-icon">';
                  echo '<i class="bx bx-user-plus" style="color: #4CAF50;"></i>';
                  echo '</div>';
                  echo '<div class="activity-details">';
                  echo '<div class="activity-title">New user registered</div>';
                  echo '<div class="activity-description">' . htmlspecialchars($activity['username']) . ' was added to the system</div>';
                  echo '<div class="activity-time">' . date('M j, Y g:i A', strtotime($activity['date_created'])) . '</div>';
                  echo '</div>';
                  echo '</div>';
                }
              } else {
                echo '<div class="no-data">No activities found</div>';
              }
              
              $conn->close();
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>