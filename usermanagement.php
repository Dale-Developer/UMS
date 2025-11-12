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
          <input type="text" id="editFullName" name="fullName" placeholder="Enter full name">
        </div>

        <div class="form-group">
          <label for="editEmail">Email Address *</label>
          <input type="email" id="editEmail" name="email" placeholder="Enter email address">
        </div>

        <div class="form-group">
          <label for="editUsername">Username *</label>
          <input type="text" id="editUsername" name="username" placeholder="Enter username">
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
            <option value="">Select a role</option>
            <option value="admin">Admin</option>
            <option value="staff">Staff</option>
            <option value="user">Regular User</option>
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
          <label>Created Date:</label>
          <span id="viewCreatedDate">-</span>
        </div>

      </div>
      <!-- 
      <div class="form-actions">
        <button type="button" class="btn btn-cancel" id="viewFormCancel">Close</button>
      </div> -->
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

      // open/close helpers
      function openModal(modal) {
        if (!modal) return;
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
      }
      function closeModal(modal) {
        if (!modal) return;
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
      }

      // basic modal wiring
      addUserBtn?.addEventListener('click', () => openModal(addModalOverlay));
      addModalClose?.addEventListener('click', () => closeModal(addModalOverlay));
      addFormCancel?.addEventListener('click', () => closeModal(addModalOverlay));

      editModalClose?.addEventListener('click', () => closeModal(editModalOverlay));
      editFormCancel?.addEventListener('click', () => closeModal(editModalOverlay));

      viewModalClose?.addEventListener('click', () => closeModal(viewModalOverlay));
      viewFormCancel?.addEventListener('click', () => closeModal(viewModalOverlay));

      [addModalOverlay, editModalOverlay, viewModalOverlay].forEach(modal => {
        if (!modal) return;
        modal.addEventListener('click', (e) => {
          if (e.target === modal) closeModal(modal);
        });
      });

      // Toggle password (add modal)
      const togglePassword = document.getElementById('togglePassword');
      const passwordInput = document.getElementById('password');
      togglePassword?.addEventListener('click', function () {
        if (!passwordInput) return;
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;
        this.innerHTML = type === 'password' ? '<i class="bx bx-hide"></i>' : '<i class="bx bx-show"></i>';
      });

      // Toggle password (edit modal)
      const editTogglePassword = document.getElementById('editTogglePassword');
      const editPasswordInput = document.getElementById('editPassword');
      editTogglePassword?.addEventListener('click', function () {
        if (!editPasswordInput) return;
        const type = editPasswordInput.type === 'password' ? 'text' : 'password';
        editPasswordInput.type = type;
        this.innerHTML = type === 'password' ? '<i class="bx bx-hide"></i>' : '<i class="bx bx-show"></i>';
      });

      // Delete buttons
      document.querySelectorAll('.btn-icon.delete').forEach(btn => {
        btn.addEventListener('click', function () {
          const uid = this.getAttribute('data-user-id') || this.dataset.userId;
          if (!uid) return;
          if (!confirm('Are you sure you want to delete this user?')) return;
          fetch(`delete_user.php?id=${encodeURIComponent(uid)}`)
            .then(r => r.text())
            .then(() => location.reload())
            .catch(err => {
              console.error('delete_user.php error:', err);
              alert('Failed to delete user. See console.');
            });
        });
      });

      // ---------- LOAD USER DETAILS FOR VIEW ----------
      function loadUserDetails(userId) {
        fetch(`get_user.php?id=${userId}`)
          .then(response => response.json())
          .then(user => {
            if (user.error) {
              alert('Error: ' + user.error);
              return;
            }

            // Populate view modal with user data
            document.getElementById('viewUserId').textContent = user.id || '-';
            document.getElementById('viewFullName').textContent = user.fullname || '-';
            document.getElementById('viewEmail').textContent = user.email || '-';
            document.getElementById('viewUsername').textContent = user.username || '-';

            // Role with styling
            const viewRole = document.getElementById('viewRole');
            viewRole.textContent = user.user_role || '-';
            viewRole.className = `role-badge ${user.user_role || ''}`;

            // Status with styling (if you have status field)
            if (document.getElementById('viewStatus')) {
              const viewStatus = document.getElementById('viewStatus');
              viewStatus.textContent = user.status || 'active';
              viewStatus.className = `status-badge ${user.status || 'active'}`;
            }

            document.getElementById('viewCreatedDate').textContent = user.date_created || '-';

            // If you have last_login field in your database
            if (document.getElementById('viewLastLogin')) {
              document.getElementById('viewLastLogin').textContent = user.last_login || '-';
            }

            openModal(viewModalOverlay);
          })
          .catch(error => {
            console.error('Error loading user details:', error);
            alert('Failed to load user details.');
          });
      }

      // ---------- LOAD USER DATA FOR EDIT ----------
      function loadUserForEdit(userId) {
        fetch(`get_user.php?id=${userId}`)
          .then(response => response.json())
          .then(user => {
            if (user.error) {
              alert('Error: ' + user.error);
              return;
            }

            // Populate edit form with user data
            document.getElementById('editUserId').value = user.id || '';
            document.getElementById('editFullName').value = user.fullname || '';
            document.getElementById('editEmail').value = user.email || '';
            document.getElementById('editUsername').value = user.username || '';

            // Set the user role
            const editUserRole = document.getElementById('editUserRole');
            if (editUserRole) {
              editUserRole.value = user.user_role || 'user';
            }

            // Clear password field for safety
            document.getElementById('editPassword').value = '';

            openModal(editModalOverlay);
          })
          .catch(error => {
            console.error('Error loading user for edit:', error);
            alert('Failed to load user data for editing.');
          });
      }

      // ---------- ATTACH VIEW BUTTON LISTENERS ----------
      document.querySelectorAll('.btn-icon.view').forEach(btn => {
        btn.addEventListener('click', function () {
          const userId = this.getAttribute('data-user-id');
          loadUserDetails(userId);
        });
      });

      // ---------- ATTACH EDIT BUTTON LISTENERS ----------
      document.querySelectorAll('.btn-icon.edit').forEach(btn => {
        btn.addEventListener('click', function () {
          const userId = this.getAttribute('data-user-id');
          loadUserForEdit(userId);
        });
      });

      // ---------- EDIT FORM SUBMISSION ----------
      const editUserForm = document.getElementById('editUserForm');
      if (editUserForm) {
        editUserForm.addEventListener('submit', function (e) {
          e.preventDefault();

          const formData = new FormData(this);

          fetch('edit_user.php', {
            method: 'POST',
            body: formData
          })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                alert('User updated successfully!');
                closeModal(editModalOverlay);
                location.reload();
              } else {
                alert('Error: ' + (data.error || 'Failed to update user'));
              }
            })
            .catch(error => {
              console.error('Error updating user:', error);
              alert('Failed to update user.');
            });
        });
      }

    }); // end DOMContentLoaded
  </script>

</body>

</html>