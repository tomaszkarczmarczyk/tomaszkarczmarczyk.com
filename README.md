# Tomasz Karczmarczyk's Blog

My personal blog.

## Installation

First install `rimraf` and `gulp-cli` globally.

```bash
npm i rimraf -g && npm i gulp-cli -g
```

Install all dependencies.

```bash
npm i
```

## Usage

Delete a `dist` directory, create a development build and start watch for file changes.

```bash
npm start
```

Delete a `node_modules` directory and install all dependencies.

```bash
npm run reinstall
```

Delete a `dist` directory.

```bash
npm run clean
```

Watch for file changes and run a task when a change occurs.

```bash
npm run watch
```

Delete a `dist` directory and create a development build.

```bash
npm run build:dev
```

Delete a `dist` directory and create a production build.

```bash
npm run build:prod
```
