
Motor Controller
================

You probably want to make your robot move around the arena. The most 
common way of doing this is using electric motors. The motor controller 
in your kit allows you to control the power delivered to two 12V motors.

## Power, not Speed ##

From your robot software, you can tell the motor controller to deliver a 
certain amount of power to the motors. (For those who are interested, the 
motor controller uses pulse-width modulation to vary the amount of power 
delivered to the motors.) There is not a linear relationship between power 
and the speed of the motor. The motor will be subject to a varying load 
(e.g. your robot may be going up a ramp, or it might be pushing some blocks). 
There is also variation between different instances of the same motor, and 
most DC motors run slightly better in one direction.

As delivered power doesn't relate directly to a specific motor speed, it's 
not really possible to just use timing to get your robot into the position 
you want.

## Feedback ##

Since a timing-based approach to motor control doesn't provide repeatable or 
reliable results, you need to find a different solution. The answer to this 
problem is "feedback". You will need to write your robot software so that it 
feeds information from relevant sensors back to your software that determines 
how to adjust the motor outputs next.

Imagine you had been blind-folded and had to walk across a large room to a 
chair. Every three steps you are allowed to take your blind-fold off and look 
around, then put the blind-fold back on before you take any more steps. When 
you are blind-folded, you have less of an idea about where you are in the room 
and you hope that your legs carry you in the right direction. Every time you 
lift up your blind-fold, you are reading your sensors, and when the blind-fold 
comes back down again you adjust the signals you send to your legs. This is a 
feedback loop. By periodically examining what needs to be done to reach a given 
target, and adjusting outputs as necessary, you will eventually reach your 
target (the chair).

Depending on how you use motors in your robot, there are several different 
sensors that you could use (and this is a non-exhaustive list):

* The webcam
* The AS5030 magnetic-rotary sensor board
* Bump-sensors

The motor controller can interface with two AS5030 boards to allow you to read 
the rotary position of wheels. The motor controller also contains a PID controller 
(see below) that allows you to move a motor to an absolute position. 

Connections
-----------

The connectors on the motor controller are shown in the following diagram:

![Motor Board](https://www.studentrobotics.org/docs/motor/images/motor-controller.png)
