# Tradingbot

A project to automate cryptocurrency trading.

# Steps taken so far

I want to make sure you understand the initial development enviromnent. So I logged everything I did to create it below. If you have any questions about the stuff below, let's discuss them right now before adding
more complexity to the project.

1. Cloned the github repository to a local folder on my PC
2. Created a ./src directory for all source code files
3. Created a ./dist directory for all distribution code (production code)
4. Used "npm init" to create initial package.json (https://docs.npmjs.com/creating-a-package-json-file). Each time we "npm install <somemodule>", it'll be added automatically to the package.json file. Using this file, you could clone the github repository then use "npm install" and it'll look into this file and install package locally for you. There's going to be two important sections in the file, one is "devDependencies" which includes all node modules required for the dev enviromnent only and another called "dependencies" which includes all node modules required for both development and production. Using this, we won't bundle modules that are only required for development making the final production release smaller. One line that I added is this one ""private": true" to prevent accidentally publishing our code to the node.js repository.
5. Used "npm i typescript ts-loader --save-dev" to install typescript (i is a shortcut for install, --save-dev tells the installer to add the typescript package to the dev section of the package.json which means this package won't be bundled in the production code (we won't need typescript in production since we'll compile typescript to simple javascript)). ts-loader is needed for #8.
6. Used "tsc --init" to create an initial tsconfig.json file (this is the configuration file for typescript, https://www.typescriptlang.org/docs/handbook/tsconfig-json.html#examples). tsc ([T]ype[S]cript [C]ompiler) is used to compile .ts files into .js files but we're going to automate that compilation using #8.
7. Created a .gitignore file to ignore/prevent some files from being committed to the repository. An important directory to exclude is node_modules, we won't modify code in there and you can easily install all that stuff as told in #4 using "npm install" in the root folder of the project. Rest of the ignores are common log files or visual studio code settings. We're going to share some visual studio settings eventually like the tab/spaces for indent but let's keep that for later.
8. Used "npm install --save-dev webpack webpack-cli" to install webpack and webpack-cli. Webpack will auto-compile files when you save in Visual Studio Code. That's the dev part but the main reason we're going to use that is to compile/bundle all the source code into one big main javascript file. There's a lot more cool stuff we can do with Webpack but let's start with the basics. I added the basic config webpack.config.js (made a comment about it in the file).
9. I then added ""build": "webpack"" in the script section of package.json to make it easier to run from the command line. The scripts section is used to create shortcut command line when we have long command line with lots of options. In this case, it's just easier to remember "npm run build".
10. I created the first line of code ./src/index.ts - it's just a "console.log("hello")". It's not even typescript in a way, it's simple javascript but it's all the same for now!

# How to run this locally

1. Clone the github repository locally
2. I suggest installing Cmder windows program to use as a console. It's behaving like a UNIX console and make it easier to develop.
3. I'm guessing you already have node.js installed.
4. In the root folder, using a console, run "npm install". It'll look for the package.json file and install all node modules required for the basic dev setup on your computer (since we're not using source control for the nodes_modules directory)
5. Run, in the console, "npm run build". That's going to rebuild the production bundle in ./dist
6. Go to the ./dist directory and run "node bundle.js". It should the run the code by printing "Hello". By the way you can run "npm run build" directly in the dist folder too.
7. Remember, we're doing backend coding here. We're going to print to the screen for useful information the bot is doing and more massive info will be logged to a file. We aren't going to use a browser here.
8. I suggest you play around by adding any kind of test code to ./src/index.ts and rebuild the code and run it again. Let's make sure you understand the process.
9. I suggest you take a look at the config files and ask any questions about why we have those config files in the project. We won't modify those files often (well a little bit at the start while we figure out our needs) but I want to make sure you aren't scared of that stuff before we start doing actual coding.
10. webpack is throwing a warning because there's a setting missing in the webpack.config.js file. It won't prevent compiling but you're welcome to fix the issue!

# Production server

1. Soon enough, we will need a production server since we're going to have one big task of collecting historical data from Binance and this would be easier to do in the cloud than locally. Testing the bot continually with the market might also be easier in the cloud to log it all. I'm not sure tho. We won't need some big scalable Docker-Swarm-Kubernetes setup for this project so a simple nano-EC2 instance could do the job which would cost us I think 3-4$/month. Let's discuss.
