# Practices for Commits

This project uses the [git flow methodology](https://nvie.com/posts/a-successful-git-branching-model/). There are three established branches that can be used for testing.
* `main` is the live branch, 
  
* `develop` is the branch that is used for staging before a release is completed

* `preview` is used for testing changes in a branch that can be completely reset at any time. NOTE: for most developers on this project the preview branch is not really relevant. 

## Flow Branches

There are three types of branches that we create to reconcile differences between a working (`feature`) branch, `develop`, and `main`. 

We create a `feature` branch of a freshly pulled copy of `develop` with the following pattern
feature/issue-[git-issue-number]/[title-of-the-issue]
FOr instance, if there is an issue #130 with a title of "Refactor button display on variety edit" then the feature branch would be  `feature/issue-130/refactor-button-display-on-variety-edit`

So the complete process for starting a branch would be as follows:

1. Switch to the `develop` branch
<pre>git checkout develop</pre>
   
2. Pull any changes from `develop`
<pre>git pull origin develop</pre>
   
3. Push any changes you have that aren't yet on `develop`
<pre>git push origin develop</pre>

4. Create your feature branch
<pre>git checkout -b feature/issue-130/refactor-button-display-on-variety-edit</pre>

5. Optionally set up a copy of your feature on Github (you can do this at any time)
<pre>git push --set-upstream origin feature/issue-130/refactor-button-display-on-variety-edit</pre>

## Making commit messages

For commits to be linked to their associated issue, you must do the following. 

1. Add changes (Best practice is to either use the UI of your IDE or use `git add -p` to review all the changes. This is important to avoid adding any accidental typos or other stuff)

2. Add a commit message that starts with the string `Issue #[number-of-issue]`. So in our case our message might say <pre>Issue #130 removed deprecated class identifiers</pre>

This way when you push your commit Github will link it to the related issue. It also makes searching the git log easier when we want to find the points when an issue's message were committed. 

## Completing a feature

When a branch has been reviewed and all work on the issue is completed, it can be merged to develop. The steps for accomplishing this are:

1. Checkout `develop` and pull and push as above
<pre>git checkout develop
git pull origin develop
git push origin develop</pre>

2. Merge develop into your branch (this is a good way to prevent conflicts)
<pre>git checkout feature/issue-130/refactor-button-display-on-variety-edit
git merge develop</pre>

3. Merge your feature branch into develop (using the example branch above)
<pre>git checkout develop
git merge feature/issue-130/refactor-button-display-on-variety-edit</pre>

4. Delete your local and remote feature branches NOTE: ONLY DO THIS WHEN YOU ARE COMPLETELY DONE WITH YOUR ISSUE
<pre>git push --delete origin feature/issue-130/refactor-button-display-on-variety-edit
git branch -D feature/issue-130/refactor-button-display-on-variety-edit
</pre>

5. Push develop
<pre>git push origin develop</pre>

## Releases

This project uses 3-level release tags. major-version.sub-version.sub-version such as 1.0.25

As soon as the right-most level reaches 99, the middle number is increased by one. So the next tag after 1.0.99 would be 1.1.0.

The process for a release is to merge develop into main, add a tag to the branch, and push the tag.

In the end develop and main should be identical. 

First get the last tag, so you can determine the next one `git describe`
This will return the latest tag. So, if the latest tag is 5.0.31, then your release tag will be 5.0.31.

Starting with a `develop` branch that is the same locally and at Github...
<pre>git checkout main
git pull main
git merge develop
git tag --5.0.31
git push main
git push tags
git push develop
</pre>

## Hotfixes

Hotfixes are similar to releases, but these are run on the rare occasion that a change needs to be made immediately on the `main` branch without merging any changes that may be pending in develop. The circumstances of this might be that items in develop are not yet ready to be released, but the fix that needs to be made must be made on live.

1. First we create a branch off of live (use the hygiene implemented above, so you know your local `main` is identical to the remote)

2. Determine the next tag
<pre>
git describe</pre>

3. Create a new hotfix branch starting from `main`. So if the next tag is 1.0.67 then:
<pre>git checkout -b hotfix/1.0.67</pre>

4. Make all the code changes you intend to make to complete your hotfix. Since hotfixes are risky, this change should be as limited as can be. Commit with using the standard process above. 

5. There is usually no need to create a remote copy of your hotfix branch. 

6. Finish the hotfix following a similar process as for releases with the difference that main is merged into develop
<pre>
git checkout main
git merge hotfix/1.0.67
git branch -D hotfix/1.0.67
git tag --1.0.67
git push main
git push --tags
git checkout develop
git pull develop
git merge main
git push develop
</pre>

## Using NVIE Git Flow tools
There are several tools available to help automate this process. The most popular is the [nvie gitflow](https://github.com/nvie/gitflow/wiki/Installation).

Git flow takes care of many of the fiddly things that can make using the git flow process frustrating and error-prone.

After installing git flow, you can initialize your local repo with the command `git flow init` There are numerous questions that emerge. You should just press enter for every one until you come back to the standard command prompt. 

To start a feature branch that you want to call `feature/issue-130/refactor-button-display-on-variety-edit` you would type
<pre>git flow feature start issue-130/refactor-button-display-on-variety-edit</pre>

Add and commit your changes.

When you want to publish your branch, you just type 
<pre>git flow feature publish</pre> This will automatically create the remote branch. 

When you are done with your branch and no longer need it, you just type:
<pre>git flow feature finish</pre>

This code takes care of merging into `develop` and deleting both the local and remote copy of your feature branch. 

When you want to start a release, get the next tag value (say it's 3.1.35) you type
<pre>git flow release start 3.1.35</pre>

Then, unless you have any last minute changes, you just type
<pre>git flow release finish</pre>

This will bring up editing dialogs asking you to enter the tag name. Just enter 3.1.35 and ctrl-x to exit the editor, 'y' to save your edits, and enter to save the file.  

Then finish up
<pre>git push main
git push --tags
git checkout develop
git push develop</pre>

Hotfixes are virtually identical. 
<pre>git flow hotfix start 3.1.35</pre>
make the changes you need to do
<pre>git flow hotfix finish
git push main
git push --tags
git checkout develop
git push develop</pre>
