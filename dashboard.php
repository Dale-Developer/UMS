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
    <!-- <link rel="stylesheet" href="styles/sidebar.css"> -->
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
          <div class="stat-card total">
            <div class="stat-header">
              <div>
                <div class="stat-title">Total Records</div>
                <div class="stat-value">4,580</div>
              </div>
              <div class="stat-icon">
                <i class="bx bxs-bar-chart-alt-2"></i>
              </div>
            </div>
          </div>

          <div class="stat-card active">
            <div class="stat-header">
              <div>
                <div class="stat-title">Active Records</div>
                <div class="stat-value">8,642</div>
              </div>
              <div class="stat-icon">
                <i class="bx bx-run"></i>
              </div>
            </div>
          </div>

          <div class="stat-card delete">
            <div class="stat-header">
              <div>
                <div class="stat-title">Deleted Records</div>
                <div class="stat-value">324</div>
              </div>
              <div class="stat-icon">
                <i class="bx bxs-trash"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="charts-grid">
          <div class="chart-card">
            <div class="chart-header">
              <div class="chart-title">Record Overview</div>
              <div class="chart-actions">
                <select>
                  <option>Last 7 days</option>
                  <option>Last 30 days</option>
                  <option>Last 90 days</option>
                </select>
              </div>
            </div>
          </div>

          <div class="chart-card">
            <div class="chart-header">
              <div class="chart-title">Activity</div>
              <div class="chart-actions">
                <select>
                  <option>Weekly</option>
                  <option>Monthly</option>
                  <option>Yearly</option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>