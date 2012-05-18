# 
# /*
#  * *********** WARNING **************
#  * This file generated by My::WrapXS/2.12
#  * Any changes made here will be lost
#  * ***********************************
#  * 1. /xampp/perl/site/lib/ExtUtils/XSBuilder/WrapXS.pm:52
#  * 2. /xampp/perl/site/lib/ExtUtils/XSBuilder/WrapXS.pm:2068
#  * 3. Makefile.PL:193
#  */
# 


package APR::Request::Cookie;
require DynaLoader ;

use strict;
use warnings FATAL => 'all';

use vars qw{$VERSION @ISA} ;

push @ISA, 'DynaLoader' ;
$VERSION = '2.12';
bootstrap APR::Request::Cookie $VERSION ;

package APR::Request::Cookie;
use APR::Request;

sub new {
    my ($class, $pool, %attrs) = @_;
    my $name  = delete $attrs{name};
    my $value = delete $attrs{value};
    $name     = delete $attrs{-name}  unless defined $name;
    $value    = delete $attrs{-value} unless defined $value;
    return unless defined $name and defined $value;

    my $cookie = $class->make($pool, $name, $class->freeze($value));
    while(my ($k, $v) = each %attrs) {
        $k =~ s/^-//;
        $cookie->$k($v);
    }
    return $cookie;
}

sub freeze { return $_[1] }
sub thaw { return shift->value }


1;
__END__