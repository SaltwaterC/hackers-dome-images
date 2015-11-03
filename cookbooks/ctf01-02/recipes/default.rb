include_recipe 'apt::default'

pkg = %w(
  xubuntu-desktop
)

package pkg
