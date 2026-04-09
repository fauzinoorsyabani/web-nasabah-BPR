---
description: Push project to GitHub repository
---

## Steps to push the `web_nasabah_BPR` project to GitHub

1. **Initialize Git (if not already initialized)**
   ```bash
   git init
   ```

2. **Add all project files**
   ```bash
   git add .
   ```

3. **Commit with an initial message**
   ```bash
   git commit -m "Initial commit"
   ```

4. **Add the remote repository**
   Replace `<USERNAME>` with your GitHub username.
   ```bash
   git remote add origin https://github.com/<USERNAME>/web-nasabah-BPR.git
   ```

5. **Rename the default branch to `main` (if needed)**
   ```bash
   git branch -M main
   ```

6. **Push to GitHub**
   ```bash
   git push -u origin main
   ```

7. **Verify on GitHub**
   Open the repository URL in a browser to ensure files are uploaded.

> **Tip:** If you encounter authentication prompts, use a Personal Access Token (PAT) with `repo` scope instead of your password.
