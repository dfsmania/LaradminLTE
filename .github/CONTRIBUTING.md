## Contributing to LaradminLTE

Thank you for your interest in contributing to **LaradminLTE**! We welcome contributions that help improve or enhance the package. To ensure a smooth collaboration process, please follow the guidelines below.

### Contribution Workflow

You can contribute using either your local machine or directly on GitHub:

#### Option 1: Local Development

1. **Fork the Repository:** Use the *GitHub interface* to create a [fork](https://docs.github.com/en/github/getting-started-with-github/fork-a-repo) of this repository.
2. **Clone Your Fork:** Run `git clone https://github.com/<your-username>/LaradminLTE.git` to clone your fork to your local machine.
3. **Create a Fix/Feature Branch:** In your local repository, create a new branch with a descriptive name for your changes.
4. **Commit Your Changes:** Make your modifications and commit them to your new branch.
5. **Push to Your Fork:** Use `git push origin <your-branch-name>` to push your branch to your fork on GitHub.
6. **Open a Pull Request:** Submit a *Pull Request* from your new branch to the main repository using the *GitHub interface*.

#### Option 2: GitHub Web Editor

1. **Fork the Repository:** Use the *GitHub interface* to create a [fork](https://docs.github.com/en/github/getting-started-with-github/fork-a-repo) of this repository.
2. **Create a New Branch:** In your fork on GitHub, use the "Branch" dropdown to create a new branch for your changes.
3. **Edit Files:** Use the GitHub web editor to make your changes directly in the browser.
4. **Commit Changes:** Commit your changes to the new branch.
5. **Open a Pull Request:** Use the *GitHub interface* to open a *Pull Request* from your branch to the main repository.

For more details, refer to the [Pull Requests guide](https://help.github.com/articles/about-pull-requests/) and the [Working with Forks guide](https://docs.github.com/en/github/collaborating-with-pull-requests/working-with-forks).

### Pull Request Guidelines

- Ensure all automated checks pass before requesting a review.
- If your *Pull Request* introduces a new feature, please add or update the relevant documentation in the `docs` folder (see [Documentation Contributions](#documentation-contributions)), or include proposed documentation in the *Pull Request* description.
- Keep contributions focused on the core functionality of the package. Avoid adding support for unrelated packages or highly specific use cases, as these can increase maintenance complexity.

We appreciate your efforts to make **LaradminLTE** better!

### Documentation Contributions

To contribute to the documentation, which is built with [Vitepress](https://vitepress.dev/):

1. **Navigate to the `docs` Directory:** All documentation source files are located in the `docs` folder at the root of the repository.
2. **Edit or Add Markdown Files:** Make your changes or add new documentation pages using Markdown (`.md`) files.
3. **Preview Locally:**
    - Install dependencies if you haven't already:
      ```bash
      npm install
      ```
    - Start the Vitepress dev server to preview your changes:
      ```bash
      npm run docs:dev
      ```
    - Visit the local URL (usually `http://localhost:5173/LaradminLTE`) to review your updates.
4. **Commit and Push:** Commit your documentation changes to your branch and push them to your fork.
5. **Pull Request:** Open a Pull Request as described above. Clearly mention that your changes affect the documentation.

Please ensure your documentation is clear, concise, and follows the existing style and structure.
