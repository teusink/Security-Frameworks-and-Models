# The very different roles of Developer, Engineer and Analyst in regard to Security Awareness

In my daily work as an Information Security Officer I talk with allot of people.
Some of them are (C-level) managers, some of them are Business Owners, and some
are Product Owners. But I talk even more to people who actually create, maintain
or break the product they are responsible for. And these are the Developers,
Engineers and Analysts.

And oh boy, how different do they approach the very same subject! Let me explain
what I have learned from that and how I put that knowledge to work in regard to
(increasing) Security Awareness. As I will explain the three different roles
further down the road in this repo, the following triangle sums it all up.

**Triangle of Work**
![](https://raw.githubusercontent.com/teusink/Security-Frameworks-and-Models/master/Triangle-of-Work/Triangle-of-Work.jpg)

## The Developer

The main focus of the developer is creating the work (or product). His or hers
primary driver is building features, testing out new develop- or
build-technologies and other tons of cool new stuff. Resistance is often felt
when stability becomes a topic of discussion. Creativity is their driver and
nothing can be really stable when creativity needs room.

## The Engineer

The main focus of the engineer is maintaining the work. He or she makes sure
that whatever the developer is creating is kept running. Often the primary focus
does not exceed criteria in the domain of availability, although there are
of-course exceptions.

Resistance is often felt when change is at hand. Everything that needs to be
changed tends to create instability. Instability is a common trade-off with
creativity which is to some degree okay to an engineer, but he or she rather
chooses stability.

## The Analyst

This is where the ‘Regular’ Testers might reside, but even more the Security
Analysts and Penetration Testers. Their main focus is breaking the work (most
often just on a theoretical basis though). And this is a kinda new-ish phenomena
in world of technology.

Now there is suddenly a guy or girl who likes to break things and they have now
even formal positions in companies! It is not only frustrating to the engineer
trying to keep all things running, it is even frustrating to the developer to
hear about many child-illnesses in their great works of art.

The analyst wants to see how works can be exploited, broken or otherwise
negatively impacted. This of-course generates insights, not to mention tons of
workloads, for both engineers and developers.

## Do not fight these natural tendencies!

Why? Well, because those tendencies are hard-wired into everyone’s brain. You
are either one of the three to the extreme, or a certain mix of two or three
roles and changing them isn’t done overnight. Can I back this up with scientific
research? No, unfortunately other than my experience in work and life I cannot
(perhaps there is though…).

For the sake of argument, let’s assume that for the better part I am right.

## Creating Security Awareness for the roles of Developer and Engineer

Many Security Officers (just like myself) try to create awareness with
developers in how to make their code more secure by design and try to create
awareness with engineers in how to harden everything the keep running. Assuming
that Security Analysts are reasonable aware of Security for now. I am not saying
these endeavors (creating awareness) are wasted money and energy, but keep in
mind they need one key ingredient. And that is commitment to learn from the
awareness.

One might say that everyone is always willing to learn more about making things
better, but making things better can be something totally different in another
one’s opinion.

### So how to start the change then?

The first step you should take is accepting the fact that the three roles of
developer, engineer and analyst exists and that they will continue to exists.
Embrace the fact that everyone looks at the same topic differently. You can
learn allot from it if you really understand how the other one is thinking about
the very same work than you.

In order to change someone’s opinion, commitment or whatever it is you want to
be changed, you need to influence. There are many books and training on putting
influence to practice, but it all boils down to this.

> You need them to feel very uncomfortable in the situation where they are now and
> give them a vision of a better place in the same time, while giving them means to reach that place.

To give an example about creating awareness concerning [Input
Validation](https://www.teusink.eu/search/label/input%20validation) for
Developers. You will have to convince the developer that NOT knowing about Input
Validation is very wrong and a terrible place to be. Then you will need to
create the vision in that awesome place where he or she as a developer knows
everything about Input Validation. But that is not enough to change. You will
need to provide means (training, tools, etc) in order for him or her to make the
change.

And that is allot of work right?

### Instead of change, why not let it reside just with influence?

Influence leads to change, and change leads to different outcomes. Awareness
focuses most often on the change itself, rather than the influence you want to
create or the outcome of said change.

What I mean with this is the following, so back to the developer again. You
could also incorporate a Security tool in the build-street that automatically
tests code and gives feedback immediately to the developer. Now the developer
has two options. Either ignore the errors or fix them. And this is were emotions
comes in (read: influence). I have yet to come across a developer who likes
compile-, build- or Lint-errors. Errors are no good and needs fixing and that’s
the driver in many cases at least.

If you can incorporate Security testing (at least to some degree) in a
developer’s daily work, you created continuous awareness training without the
pain of creating it in the minds first. Instead you work the other way around.
You make sure that the means for improving are already in place, and by the
means you create insight in the awful place they are (no Input Validation
knowledge). And the means and insights helps you to become more Secure by
Design.

## Conclusion

There is no single road that leads to better Security awareness, so keep
awareness fit for your audience and focus on the result, supply the means and
forget about the change itself (that will come by itself). But also do realize
that the three roles will never go away, and that you need all three roles in
your team or department to make good decisions.

Help Developer, Engineers and Analysts understand that everyone has to do their
part in the greater picture of Technology. When there is respect for each-others
opinions and drivers, people will open up and will be more eager to learn from
one another. Bashing Developers for yet another vulnerability will not improve
Security Awareness and bashing an Engineer for not patching neither.

Implement the means (processes and/or tools) that help Developers and Engineers
to (preferably automatically) help them improve Security. The Analyst can then
play a tremendous role with helping both roles to continuously improve that.

And I am convinced that when you can create such a culture as a Security
Officer, you will dramatically improve the overall security!

*****
