; Radix Core Makefile

api = 2
core = 7.x

; Radix Theme

projects[radix][type] = theme
projects[radix][version] = 3.6
projects[radix][subdir] = contrib

; Radix Modules

projects[radix_layouts][type] = module
projects[radix_layouts][version] = 3.4
projects[radix_layouts][subdir] = contrib

projects[radix_admin][type] = module
projects[radix_admin][download][type] = git
projects[radix_admin][download][branch] = 7.x-3.x
projects[radix_admin][subdir] = contrib
