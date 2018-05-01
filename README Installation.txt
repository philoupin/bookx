What is the best way to add BookX to your ZenCart installation?

If you plan to develop BookX further and would like to continue to use the GitHub depository for BookX, it may be easiest NOT to copoy all the BookX files into the ZenCart system (as it is explained in the Documentation), but rather leave the structure of the BookX distribution unchanged and create symbolic links for the files inside the zen cart folder.
There is a shell script "create_symbolic_links.sh" included here, which automates this task.

Symbolic links should work on Linux and MacOs. If you upload the files to your provider, you may have to recreate the symbolic links there.
