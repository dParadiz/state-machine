# Finite State Machine (FSM)

This is simple frame for working FSM. Framework consist of few abstract classes and interfaces that can be used to build FSM.
Framework is dependent on `Symfony\Component\HttpFoundation\Request` which is used as FSM input. 

Framework consists of following parts

 - Abstract StateMachine 
 - Abstract State 
 - Transition
 - Action interface
 - Guard interface 

 
**Abstract StateMachine** implementation takes care of execution chain of state entry/exit actions and transition guards/actions
when request is revived. It also machine uses `Variables` trait which adds option to set variables in state machine scope.

> Execution steps for transition from current state (CS) to new state (NS)
>
> CS Entry Actions > CS Exit Actions > Transition Guards > Transition Action > NS Entry Actions

**Abstract State** implementation holds all entry/exit actions and transitions that chan be executed from the state.
It implements execution chain of entry/exit actions. Actions are executed in the same order that they were added to the state.
All concrete state implementation must extend Abstract state. If concrete state implementation has some output values function
`getOutput()` must be implemented. It also uses `Variables` trait which adds option to set variables in state scope. 
All states have access to variables in state machine scope.

**Transition** is holder of guards and next state. It implements execution chain of guards. To implement transition action
base transition needs to be extended and `execute()` implemented.

**Action interface** defines functions which are needed in concrete action implementation.

**Guard interface** defines functions which are needed in concrete guard implementation.


## Examples

###Switch state machine

Simple implementation of state machine which changes state on every request.

###Puzzle game

Implementation of logic puzzle in with state machine. This example shows usages of guards, and state actions and use of twig renderer
for state machine output.

## Considering to do

- StateMachine builder form configuration file
- Removing dependency on `Symfony\Component\HttpFoundation\Request` as input parameter 
