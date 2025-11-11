<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="styles/usermanagement.css" />
  <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
  <title>User Management</title>
</head>

<body>
  <!-- SIDEBAR -->
  <?php include 'sidebar.php'; ?>
  <!-- Page Header -->
  <div class="page-header">
    <h1 class="page-title">User Management</h1>
  </div>

  <!-- Main Content -->
  <div class="content-container">
    <!-- CRUD BUTTONS -->
    <div class="crud-buttons">
      <button class="btn btn-primary" id="addUserBtn">
        <i class='bx bx-plus'></i> Add User
      </button>
      <!-- <button class="btn btn-danger" id="deleteBtn">
          <i class='bx bx-trash'></i> Delete
        </button>
        <button class="btn btn-cancel" id="cancelDelete" style="display: none;">
          <i class='bx bx-x'></i> Cancel
        </button> -->
    </div>

    <!-- USER MANAGEMENT TABLE -->
    <div class="table-container">
      <table class="user-table" id="userTable">
        <thead>
          <tr>
            <th scope="col" class="checkbox-column" style="display: none;">
              <input type="checkbox" class="select-all" id="selectAll">
            </th>
            <th scope="col">ID</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
            <th scope="col">Status</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          include 'db_connect.php';

          $sql = "SELECT * FROM users ORDER BY id ASC";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $status = isset($row['status']) ? ucfirst($row['status']) : 'Active'; // Default if null
              $roleClass = strtolower($row['user_role']);
              $statusClass = strtolower($status);

              echo "<tr>
        <td class='checkbox-column' style='display: none;'>
          <input type='checkbox' class='select-user'>
        </td>
        <td>{$row['id']}</td>
        <td>" . htmlspecialchars(explode(' ', $row['fullname'])[0]) . "</td>
        <td>" . htmlspecialchars(explode(' ', $row['fullname'])[1] ?? '') . "</td>
        <td>" . htmlspecialchars($row['username']) . "</td>
        <td>" . htmlspecialchars($row['email']) . "</td>
        <td><span class='role {$roleClass}'>" . ucfirst($row['user_role']) . "</span></td>
        <td><span class='status {$statusClass}'>{$status}</span></td>
        <td class='actions'>
          <button class='btn-icon view' title='View' data-user-id='{$row['id']}'>
            <i class='bx bx-show'></i>
          </button>
          <button class='btn-icon edit' title='Edit' data-user-id='{$row['id']}'>
            <i class='bx bx-edit'></i>
          </button>
          <button class='btn-icon delete' title='Delete' data-user-id='{$row['id']}'>
            <i class='bx bx-trash'></i>
          </button>
        </td>
      </tr>";
            }
          } else {
            echo "<tr><td colspan='9' style='text-align:center;'>No users found.</td></tr>";
          }

          $conn->close();
          ?>
        </tbody>

      </table>
    </div>
  </div>

  <!-- Add User Modal -->
  <div class="modal-overlay" id="addModalOverlay">
    <div class="modal-container">
      <div class="modal-header">
        <h2 class="modal-title">Add New User</h2>
        <button class="modal-close" id="addModalClose">
          <i class='bx bx-x'></i>
        </button>
      </div>

      <form class="user-form" id="userForm" method="POST" action="add_user.php">
        <div class="form-group">
          <label for="fullName">Full Name *</label>
          <input type="text" id="fullName" name="fullName" required placeholder="Enter full name">
        </div>

        <div class="form-group">
          <label for="email">Email Address *</label>
          <input type="email" id="email" name="email" required placeholder="Enter email address">
        </div>

        <div class="form-group">
          <label for="username">Username *</label>
          <input type="text" id="username" name="username" required placeholder="Enter username">
        </div>

        <div class="form-group">
          <label for="password">Password *</label>
          <div class="password-input">
            <input type="password" id="password" name="password" required placeholder="Enter password">
            <button type="button" class="toggle-password" id="togglePassword">
              <i class='bx bx-hide'></i>
            </button>
          </div>
        </div>

        <div class="form-group">
          <label for="userRole">User Role *</label>
          <select id="userRole" name="userRole" required>
            <option value="">Select a role</option>
            <option value="admin">Admin</option>
            <option value="staff">Staff</option>
            <option value="user">Regular User</option>
          </select>
        </div>

        <div class="form-actions">
          <button type="button" class="btn btn-cancel" id="addFormCancel">Cancel</button>
          <button type="submit" class="btn btn-primary">Create User</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit User Modal -->
  <div class="modal-overlay" id="editModalOverlay">
    <div class="modal-container">
      <div class="modal-header">
        <h2 class="modal-title">Edit User</h2>
        <button class="modal-close" id="editModalClose">
          <i class='bx bx-x'></i>
        </button>
      </div>

      <form class="user-form" id="editUserForm" method="POST" action="edit_user.php">
        <input type="hidden" id="editUserId" name="userId">

        <div class="form-group">
          <label for="editFullName">Full Name *</label>
          <input type="text" id="editFullName" name="fullName" required placeholder="Enter full name">
        </div>

        <div class="form-group">
          <label for="editEmail">Email Address *</label>
          <input type="email" id="editEmail" name="email" required placeholder="Enter email address">
        </div>

        <div class="form-group">
          <label for="editUsername">Username *</label>
          <input type="text" id="editUsername" name="username" required placeholder="Enter username">
        </div>

        <div class="form-group">
          <label for="editPassword">Password (Leave blank to keep current)</label>
          <div class="password-input">
            <input type="password" id="editPassword" name="password" placeholder="Enter new password">
            <button type="button" class="toggle-password" id="editTogglePassword">
              <i class='bx bx-hide'></i>
            </button>
          </div>
        </div>

        <div class="form-group">
          <label for="editUserRole">User Role *</label>
          <select id="editUserRole" name="userRole" required>
            <option value="admin">Admin</option>
            <option value="staff">Staff</option>
            <option value="user">Regular User</option>
          </select>
        </div>

        <div class="form-group">
          <label for="editStatus">Status *</label>
          <select id="editStatus" name="status" required>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
        </div>

        <div class="form-actions">
          <button type="button" class="btn btn-cancel" id="editFormCancel">Cancel</button>
          <button type="submit" class="btn btn-primary">Update User</button>
        </div>
      </form>
    </div>
  </div>

  <!-- View User Modal -->
  <div class="modal-overlay" id="viewModalOverlay">
    <div class="modal-container">
      <div class="modal-header">
        <h2 class="modal-title">User Details</h2>
        <button class="modal-close" id="viewModalClose">
          <i class='bx bx-x'></i>
        </button>
      </div>

      <div class="user-details">
        <div class="detail-group">
          <label>User ID:</label>
          <span id="viewUserId">-</span>
        </div>
        <div class="detail-group">
          <label>Full Name:</label>
          <span id="viewFullName">-</span>
        </div>
        <div class="detail-group">
          <label>Email Address:</label>
          <span id="viewEmail">-</span>
        </div>
        <div class="detail-group">
          <label>Username:</label>
          <span id="viewUsername">-</span>
        </div>
        <div class="detail-group">
          <label>Role:</label>
          <span id="viewRole" class="role-badge">-</span>
        </div>
        <div class="detail-group">
          <label>Status:</label>
          <span id="viewStatus" class="status-badge">-</span>
        </div>
        <div class="detail-group">
          <label>Created Date:</label>
          <span id="viewCreatedDate">-</span>
        </div>
        <div class="detail-group">
          <label>Last Login:</label>
          <span id="viewLastLogin">-</span>
        </div>
      </div>

      <div class="form-actions">
        <button type="button" class="btn btn-cancel" id="viewFormCancel">Close</button>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Modal elements
      const addUserBtn = document.getElementById('addUserBtn');
      const addModalOverlay = document.getElementById('addModalOverlay');
      const addModalClose = document.getElementById('addModalClose');
      const addFormCancel = document.getElementById('addFormCancel');

      const editModalOverlay = document.getElementById('editModalOverlay');
      const editModalClose = document.getElementById('editModalClose');
      const editFormCancel = document.getElementById('editFormCancel');

      const viewModalOverlay = document.getElementById('viewModalOverlay');
      const viewModalClose = document.getElementById('viewModalClose');
      const viewFormCancel = document.getElementById('viewFormCancel');

      // Password toggles
      const togglePassword = document.getElementById('togglePassword');
      const passwordInput = document.getElementById('password');
      const editTogglePassword = document.getElementById('editTogglePassword');
      const editPasswordInput = document.getElementById('editPassword');

      // Delete mode elements
      const deleteBtn = document.getElementById('deleteBtn');
      const cancelDeleteBtn = document.getElementById('cancelDelete');
      const selectAllCheckbox = document.getElementById('selectAll');
      let isDeleteMode = false;

      // Open modals
      addUserBtn.addEventListener('click', function () {
        openModal(addModalOverlay);
      });

      // Edit buttons
      const editButtons = document.querySelectorAll('.btn-icon.edit');
      editButtons.forEach(button => {
        button.addEventListener('click', function () {
          const userId = this.getAttribute('data-user-id');
          loadUserData(userId);
          openModal(editModalOverlay);
        });
      });

      // View buttons
      const viewButtons = document.querySelectorAll('.btn-icon.view');
      viewButtons.forEach(button => {
        button.addEventListener('click', function () {
          const userId = this.getAttribute('data-user-id');
          loadUserDetails(userId);
          openModal(viewModalOverlay);
        });
      });

      // Close modals
      function closeModal(modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
      }

      function openModal(modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
      }

      // Modal close events
      addModalClose.addEventListener('click', () => closeModal(addModalOverlay));
      addFormCancel.addEventListener('click', () => closeModal(addModalOverlay));

      editModalClose.addEventListener('click', () => closeModal(editModalOverlay));
      editFormCancel.addEventListener('click', () => closeModal(editModalOverlay));

      viewModalClose.addEventListener('click', () => closeModal(viewModalOverlay));
      viewFormCancel.addEventListener('click', () => closeModal(viewModalOverlay));

      // Close modals when clicking outside
      [addModalOverlay, editModalOverlay, viewModalOverlay].forEach(modal => {
        modal.addEventListener('click', function (e) {
          if (e.target === modal) {
            closeModal(modal);
          }
        });
      });

      // Toggle password visibility
      togglePassword.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.innerHTML = type === 'password' ? '<i class="bx bx-hide"></i>' : '<i class="bx bx-show"></i>';
      });

      editTogglePassword.addEventListener('click', function () {
        const type = editPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        editPasswordInput.setAttribute('type', type);
        this.innerHTML = type === 'password' ? '<i class="bx bx-hide"></i>' : '<i class="bx bx-show"></i>';
      });

      // Load user data for editing (mock data - replace with actual API call)
      function loadUserData(userId) {
        // Mock user data - replace with actual data from your backend
        const userData = {
          '1': {
            fullName: 'Mark Otto',
            email: 'mark.otto@email.com',
            username: '@mdo',
            role: 'admin',
            status: 'active'
          },
          '2': {
            fullName: 'Jacob Thornton',
            email: 'jacob.thornton@email.com',
            username: '@fat',
            role: 'user',
            status: 'active'
          },
          '3': {
            fullName: 'John Doe',
            email: 'john.doe@email.com',
            username: '@johnd',
            role: 'staff',
            status: 'active'
          }
        };

        const user = userData[userId];
        if (user) {
          document.getElementById('editUserId').value = userId;
          document.getElementById('editFullName').value = user.fullName;
          document.getElementById('editEmail').value = user.email;
          document.getElementById('editUsername').value = user.username;
          document.getElementById('editUserRole').value = user.role;
          document.getElementById('editStatus').value = user.status;
        }
      }

      // Load user details for viewing (mock data - replace with actual API call)
      function loadUserDetails(userId) {
        // Mock user details - replace with actual data from your backend
        const userDetails = {
          '1': {
            fullName: 'Mark Otto',
            email: 'mark.otto@email.com',
            username: '@mdo',
            role: 'admin',
            status: 'active',
            createdDate: '2024-01-15',
            lastLogin: '2024-03-20 14:30'
          },
          '2': {
            fullName: 'Jacob Thornton',
            email: 'jacob.thornton@email.com',
            username: '@fat',
            role: 'user',
            status: 'active',
            createdDate: '2024-02-10',
            lastLogin: '2024-03-19 09:15'
          },
          '3': {
            fullName: 'John Doe',
            email: 'john.doe@email.com',
            username: '@johnd',
            role: 'staff',
            status: 'active',
            createdDate: '2024-01-20',
            lastLogin: '2024-03-18 16:45'
          }
        };

        const user = userDetails[userId];
        if (user) {
          document.getElementById('viewUserId').textContent = userId;
          document.getElementById('viewFullName').textContent = user.fullName;
          document.getElementById('viewEmail').textContent = user.email;
          document.getElementById('viewUsername').textContent = user.username;
          document.getElementById('viewRole').textContent = user.role.charAt(0).toUpperCase() + user.role.slice(1);
          document.getElementById('viewRole').className = `role-badge ${user.role}`;
          document.getElementById('viewStatus').textContent = user.status.charAt(0).toUpperCase() + user.status.slice(1);
          document.getElementById('viewStatus').className = `status-badge ${user.status}`;
          document.getElementById('viewCreatedDate').textContent = user.createdDate;
          document.getElementById('viewLastLogin').textContent = user.lastLogin;
        }
      }

      // Delete mode functionality
      deleteBtn.addEventListener('click', function () {
        isDeleteMode = !isDeleteMode;
        toggleDeleteMode(isDeleteMode);
      });

      cancelDeleteBtn.addEventListener('click', function () {
        isDeleteMode = false;
        toggleDeleteMode(false);
        resetCheckboxes();
      });

      selectAllCheckbox.addEventListener('change', function () {
        const userCheckboxes = document.querySelectorAll('.select-user');
        userCheckboxes.forEach(checkbox => {
          checkbox.checked = selectAllCheckbox.checked;
        });
      });

      function toggleDeleteMode(enable) {
        const checkboxColumns = document.querySelectorAll('.checkbox-column');
        const actionButtons = document.querySelectorAll('.actions');

        if (enable) {
          checkboxColumns.forEach(col => col.style.display = 'table-cell');
          actionButtons.forEach(btn => btn.style.display = 'none');
          deleteBtn.style.display = 'none';
          cancelDeleteBtn.style.display = 'flex';
        } else {
          checkboxColumns.forEach(col => col.style.display = 'none');
          actionButtons.forEach(btn => btn.style.display = 'flex');
          deleteBtn.style.display = 'flex';
          cancelDeleteBtn.style.display = 'none';
        }
      }

      function resetCheckboxes() {
        selectAllCheckbox.checked = false;
        const userCheckboxes = document.querySelectorAll('.select-user');
        userCheckboxes.forEach(checkbox => {
          checkbox.checked = false;
        });
      }
    });
  </script>
</body>

</html>