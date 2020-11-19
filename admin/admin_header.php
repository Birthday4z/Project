<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="/project/admin/admin.php">Admin Management System</a>
    </div>

    <ul class="collapse navbar-collapse list-unstyled">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/project/admin/invoice/invoice.php">Invoice Management</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="/project/admin/petition/petition.php">Petition Managemant</a>
      </li>

    </ul>

        <ul class="nav navbar-nav navbar-right">
            <form action="/project/admin/logout.php" method="POST">
                <li>
                    <button type="submit" class="btn btn-danger">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-x-octagon-fill"
                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                        </svg> Logout
                    </button>
                </li>
            </form>
        </ul>

    </div>
</nav>