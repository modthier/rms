---
description: "Use when running or adding database-backed tests, migrations, or test setup. Prevents tests from wiping or modifying a developer's database."
---
# Database Testing Safety

- Never run tests against the database configured in `.env` or another database that may contain user data.
- Before running database-backed tests, verify they use an isolated test database. Prefer a temporary SQLite database or a dedicated disposable test database explicitly configured for the test command.
- Do not run `RefreshDatabase`, `migrate:fresh`, database resets, truncation, or destructive cleanup unless the test database is confirmed isolated.
- If isolation cannot be verified, do not execute the tests; explain the risk and ask before proceeding.
