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


package APR::Request::Apache2;
require DynaLoader ;

use strict;
use warnings FATAL => 'all';

use vars qw{$VERSION @ISA} ;

push @ISA, 'DynaLoader' ;
$VERSION = '2.12';
bootstrap APR::Request::Apache2 $VERSION ;

use APR::Request;
push @ISA, "APR::Request";


1;
__END__
