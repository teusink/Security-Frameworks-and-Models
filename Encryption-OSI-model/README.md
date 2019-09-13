# Guide for building an Encryption Policy

## 1. Introduction

Are you a Security Officer and familiar with the question *what is the baseline
or policy for encryption*? Or are you an engineer who has asked that very
question? Or are you a power user that wants to learn more about setting up an
encryption policy?

As an IT Security Officer I have faced a similar question in the past, and I
will try to answer it in this serie of blog-posts. Keep in mind that I talk
mostly about the *what *here, not the *how*.

I have searched online allot about this topic and I hope I curated the right
bits of information. Have to say, good encryption books are expensive and its
content are mostly very detailed. Besides that, it is still a rather complex
topic to deal with because it has many angles to approach it. In any case,
always consider the protection of data first, before jumping to a solution like
encryption. There are more ways to safeguard data and encryption just might not
solve the actual problem you need to solve.

And be aware, an algorithm can be 100% secure, while the implementation of the
algorithm can make it incredibly vulnerable. When choosing an implementation
consider the fact that it can be weak and that it needs to be tested thoroughly.

### 1.1. General approach to Encryption

Applying encryption gets cheaper, but it is still not always free and often not
the default. You will have to think about why you want to apply encryption,
where you want to apply it and how long the data needs to be secret. If it needs
to be secret for 1 day it might actually be smart to choose an algorithm that is
more easy on the CPU-cycles. But if it needs to be secret for 10 years you might
make a different choice altogether.

There is also the [Kerckhoffs’s
principle](https://en.wikipedia.org/wiki/Kerckhoffs%27s_principle). This
principle basically says that the security of an encrypted message is not based
on the secrecy of the algorithm, but on the secrecy of the key and the key only.
This is important. All common algorithms follow this principle and it is key
that this is the policy. Only publicly tested, open algorithms that follow the
Kerckhoffs’s principle should be used. Due to this principle, I left out all
encryption algorithms that are patented.

When you look at the variety of encryption and hashing algorithms you honestly
do not have that many choices. Yes, you can choose a variety of key-lengths and
in some cases a different encryption level and some other settings like
block-modes. But I tend to say that creating too much diversity in your own
ecosystem just makes encryption more expensive administratively speaking, than
when you choose a certain baseline. And don’t forget you need to test every
option you choose.

### 1.2. The General Policy should be…

* All chosen algorithms are open and publicly known for its security.
* All chosen algorithms need comply to the Kerckhoffs’s principle.
* An algorithm should not be chosen when it is either theoretically or practically compromised/cracked.
* The chosen algorithm should be sufficient enough to keep the data secret, for as long as it needs to be secret.
* Always follow the principle of “comply or explain”. When it is not technically possible to use a better encryption or hashing, you might downgrade. But do this wisely with proper Risk Management and testing.

## 2. Hashing Algorithms

### 2.1. An overview on Hashing

Hashing is a way to ‘fingerprint’ a message. A message can literally be a
message, but it can also be, for instance, a file. This fingerprint is a string
of characters and numbers.

Example: “*77c5b98cd533621c15d996723999d19d6c09513f54fddd2d1bdb32c08b6307b6*” is
the MD5 fingerprint for “*teusink.eu*”. The fingerprint is normally called a
hash. This hash is unique to, in this case, teusink.eu. If I would generate a
hash of Teusink.eu (mind the capital T here), then it would generate a different
hash. You can test it out on the webpage of David Ciamarro
([www.timestampgenerator.com](http://www.timestampgenerator.com/tools/sha256-generator/)).

In other words, with hashing you can check if your message is sent or received
intact. It checks the integrity of the data. And that is all that it does. It is
not an encryption, and a hash cannot be unhashed. It is always a one-way street.
You can never return from the fingerprint back to its original message.

### 2.2. The different algorithms

There are a variety of different hashing-algorithms out in the open. The ones
below are the most well-known (excluding niche variants).

* BLAKE: [BLAKE](https://en.wikipedia.org/wiki/BLAKE_(hash_function)), [BLAKE2](https://en.wikipedia.org/wiki/BLAKE_(hash_function)#BLAKE2)
* [CubeHash](https://en.wikipedia.org/wiki/CubeHash)
* Message Digest: [MD2](https://en.wikipedia.org/wiki/MD2_(cryptography)), [MD4](https://en.wikipedia.org/wiki/MD4), [MD5](https://en.wikipedia.org/wiki/MD5) and [MD6](https://en.wikipedia.org/wiki/MD6) 
* RACE Integrity Primitives Evaluation Message Digest: [RIPEMD](https://en.wikipedia.org/wiki/RIPEMD)-160, RIPEMD-256, RIPEMD-320
* Secure Hashing Algorithm: [SHA-1](https://en.wikipedia.org/wiki/SHA-1), [SHA-2](https://en.wikipedia.org/wiki/SHA-2), [SHA-3](https://en.wikipedia.org/wiki/SHA-3)

According to current standards (dated April 4th, 2016) the situation is as
follows.

* Deemed insecure: MD2, MD4, MD5, MD6 and SHA-1
* Deemed secure, but uncommon: BLAKE, BLAKE2, RIPEMD-160, RIPEMD-256, RIPEMD-320 and SHA-3
* Deemed secure and common: SHA-2

SHA-2 has a variety of configurations. The following configuration is the most
relevant concerning the quality of security of the hash.

* Block size: at least 512-bit, but preferably 1024-bit or higher
* Output size: at least 256-bit (SHA-256), but preferably 384-bit (SHA-384) or higher

### 2.3. Salting

The phrase salting is commonly used in conjunction with hashing. Although
hashing is often used without salting, it is extremely advised to be used when
it comes down to storing passwords or pass-phrases. Salting is the process of
adding random data to a message you want to hash (in this case, the password).
Salting makes it allot tougher to use crack tools to either guess or crack
hashes, because it appends unpredictable data to a hash before it is stored in a
database or in a file.

The best practices to use with salting is the fact that every salt is unique,
randomized and that it is not being reused. And the salt itself should not be
too short. A good method to follow here is that when the output size of a hash
is 256-bit, which is 32 bytes, you need a salt of 32 bytes. And the last bit is
not to double hashing or use multiple hashes. Proper salting with an up to date
algorithm is secure enough.

For allot of details about salting and hashing passwords, please check this
blog-post [Secure Salted Password
Hashing](https://crackstation.net/hashing-security.htm), by Defuse Security.

### 2.4. The Hashing Policy should be…

**Hashing algorithm: SHA-2:**

* Block size: at least 512-bit, but preferably 1024-bit or higher.
* Output size: at least 256-bit, but preferably 512-bit or higher.
* Security: at least 128-bit, but preferably 256-bit or higher.

**Salt a message before hashing when used to store passwords / passphrases:**

* Every salt is unique, randomized and not reused anywhere else.
* Every salt is as long as the output size in bytes of a hash of the message.

**Only use one hashing technique for one message.**

*****

## 2. Encryption Algorithms

### 2.1. Encryption versus Hashing

Encryption is, unlike hashing, an algorithm that has a two-way street. You can
actually decrypt your message (or file, or whatever you want to encrypt).
Encryption does not have a hash like hashing does, so it does not guarantee
integrity of your data. It does protect the confidentiality of the message
though. Please do keep this in mind. If you want to have confidentiality of your
data and you want to safeguard the data’s integrity, you will need to use
hashing in conjunction with encryption.

But that is not all. Besides confidentiality encryption can also secure its
non-repudiation. Non-repudiation is the fact that a party cannot deny that it
has executed an activity. This can be very important to increase your audit and
logging data to forensics level. But non-repudiation does not come by itself,
you have to do something for it which I will explain later.

### 2.2. An overview on Encryption

Encryption can be symmetric and asymmetric. Symmetric encryption can be based on
either stream-ciphers, or block-ciphers. Asymmetric encryption is either based
on discreet logarithms or based on factoring the products of large primes. See
the figure below which displays this schematically.

![](https://raw.githubusercontent.com/teusink/Security-Frameworks-and-Models/master/Encryption-OSI-model/Overview-of-Cryptographic-Systems.png)

### 2.3. Symmetric Encryption

Symmetric key algorithms use the same key in both encryption and decryption
process. This technique provides confidentiality. It does not provide
non-repudiation.

#### 2.3.1. Stream-ciphers
*Stream-ciphers* are based on generating an infinite
cryptographic key-stream and it encrypts a bit or a byte at a time.
Stream-ciphers is used when the amount of data that is being sent is unknown.
Algorithms (excluding niche variants, patented and specific use algorithms) that
are stream-ciphers:

* [ChaCha20](https://en.wikipedia.org/wiki/Salsa20#ChaCha_variant)
* [HC-128](https://en.wikipedia.org/wiki/HC-256) and [HC-256](https://en.wikipedia.org/wiki/HC-256)
* [Rabbit](https://en.wikipedia.org/wiki/Rabbit_(cipher))
* [Rivest Cipher 4](https://en.wikipedia.org/wiki/RC4) (RC4)
* [Salsa20](https://en.wikipedia.org/wiki/Salsa20)

According to current standards (dated April 4th, 2016) are as follows.

* Deemed insecure: RC4, Salsa20
* Deemed secure, but uncommon: HC-128, HC-256, Rabbit
* Deemed secure and common: ChaCha20

ChaCha20, HC, and Rabbit can have a variety of key lengths of 128 and 256-bit.

Full list of stream-ciphers can be found on
[Wikipedia](https://en.wikipedia.org/wiki/Stream_cipher).

#### 2.3.2. Block-ciphers
*Block-ciphers* are roughly the same as stream-ciphers, but
instead of using bits or bytes to encrypt it uses blocks of data. This is best
used in situations where the amount of data to send is pre-known. There are
multiple modes of block operations (to which I won’t go in detail), but you can
see the differentiation below.

* For messages at rest:
[ECB](https://en.wikipedia.org/wiki/Block_cipher_mode_of_operation#Electronic_Codebook_.28ECB.29),
[CBC](https://en.wikipedia.org/wiki/Block_cipher_mode_of_operation#Cipher_Block_Chaining_.28CBC.29),
[PCBC](https://en.wikipedia.org/wiki/Block_cipher_mode_of_operation#Propagating_Cipher_Block_Chaining_.28PCBC.29)
* For messages in transit:
[CFB](https://en.wikipedia.org/wiki/Block_cipher_mode_of_operation#Cipher_Feedback_.28CFB.29),
[OFB](https://en.wikipedia.org/wiki/Block_cipher_mode_of_operation#Output_Feedback_.28OFB.29),
[CTR](https://en.wikipedia.org/wiki/Block_cipher_mode_of_operation#Counter_.28CTR.29)
* For Wireless LAN: [CCMP](https://en.wikipedia.org/wiki/CCMP)

Algorithms (excluding niche variants, patented and specific use algorithms) that
are block-ciphers:

* [Advanced Encryption Standard](https://en.wikipedia.org/wiki/Advanced_Encryption_Standard) (AES, Rijndael)
* [BlowFish](https://en.wikipedia.org/wiki/Blowfish_(cipher))
* CAST: [CAST-128](https://en.wikipedia.org/wiki/CAST-128), [CAST-256](https://en.wikipedia.org/wiki/CAST-256)
* Data Encryption Standard: [DES](https://en.wikipedia.org/wiki/Data_Encryption_Standard), [Triple DES](https://en.wikipedia.org/wiki/Triple_DES) (3DES)
* [MacGuffin](https://en.wikipedia.org/wiki/MacGuffin_(cipher))
* Rivest Cipher: [RC5](https://en.wikipedia.org/wiki/RC5), [RC6](https://en.wikipedia.org/wiki/RC6)
* [ThreeFish](https://en.wikipedia.org/wiki/Threefish)
* [TwoFish](https://en.wikipedia.org/wiki/Twofish)

According to current standards (dated April 4th, 2016) the situation is as
follows.

* Deemed insecure: BlowFish, DES, MacGuffin, RC5, ThreeFish, Triple DES
* Deemed secure, but uncommon: CAST-128, CAST-256, RC6
* Deemed secure and common: AES, TwoFish

AES, CAST, RC6, and TwoFish can have a variety of key lengths of 128, 192 and
256-bit.

In any case, I would advice to go for the maximum here (whenever possible),
which would be 256-bit. Although 192-bit should be enough also for the
foreseeable future.

Full list of block-ciphers can be found on [Wikipedia](https://en.wikipedia.org/wiki/Block_cipher).

### 2.4. Asymmetric Encryption

Asymmetric has some form of a key-exchange with such a result that a different
key is used to encrypt and decrypt a message. This technique provides
confidentiality and non-repudiation. Confidentiality is provided when the sender
uses the receiver’s public key to encrypt the message. Non-repudiation is
provided when the sender’s private key is used to encrypt a message. If you need
both confidentiality and non-repudiation the sender needs to double-encrypt the
message with the private key of the sender and the public key of the receiver.

#### 2.4.1. Key Agreement
Asymmetric uses a key agreement protocol to exchange the public
keys between the sender and receiver of a message. There are a variety of key
agreement protocols.

* [Diffie-Hellman Key Exchange](https://en.wikipedia.org/wiki/Diffie%E2%80%93Hellman_key_exchange)
* [MQV](https://en.wikipedia.org/wiki/MQV)
* [Oakley Key Determination Protocol](https://en.wikipedia.org/wiki/Oakley_protocol)

The most generally used protocol is the Diffie-Hellman Key Exchange protocol.

#### 2.4.2. Algorithms
According to current standards (dated April 4th, 2016) the
situation is as follows.

* Deemed insecure: ECC, ElGamal, RSA (1024-bit)
* Deemed secure, but uncommon: RSA (3072-bit)
* Deemed secure and common: RSA (2048-bit)

RSA can have a variety of key lengths.

* 1024-bit (equivalent to 80-bit symmetric keys)
* 2048-bit (equivalent to 128-bit symmetric keys)
* 3072-bit (equivalent to 256-bit symmetric keys)

In any case, I would advice to go at least for the 2048-bit variant of RSA. RSA
with 1024-bit key should be prohibited and with sensitive data the key should be
3072-bit.

### 2.5. The Security Policy should be…

**Symmetric Encryption**

Stream-ciphers:

* None (due to patenting).

Block-ciphers:

* AES: at least 192-bit key-size, but preferably 256-bit
* TwoFish: at least 192-bit key-size, but preferably 256-bit

**Asymmetric Encryption**

* Key Agreement: Diffie-Hellman
* Algorithm: RSA, at least 2048-bit key-size, but preferably 3072-bit.

*****

## 3. Encryption Implementations

Encryption means nothing if you don’t actually implement it. The French
cipher machine in the shape of a book dates from the 16th century and was
owned by King Henri II which implemented a version of cryptography
([Wikipedia source](https://en.wikipedia.org/wiki/Henry_II_of_France)).

But what are the common practices today? In the first two blog-posts I have set
out a baseline for the policies concerning hashing and encryption. I have
described the various algorithms and stated which ones should be used and which
ones shouldn’t.

In this part I will look at the variety of different implementations and I will
focus on the ones that are common today (and hopefully tomorrow).

### 3.1. Encryption mapped on OSI-model

First I want to take a look in which phases of a data in transit and at rest
encryption can takes place. This is important to know, but yet often overlooked.
Management pressure often beholds comments like: “we need to do encryption” or
“encrypt every network connection”. The truth is that most likely your network
is a complex network and applying encryption technique is nowhere as easy as
like your management stating that you have to implement it.

For the purpose of this post I created a model that gives an overview on which
places encryption can take place and in what form. After this model I will
briefly explain the variety of options shown in the image. For the record, the
image is released under the [Creative Commons Attribution-NoDerivatives 4.0
International License](https://creativecommons.org/licenses/by-nd/4.0/), so
please share it in every way you like.

![](https://raw.githubusercontent.com/teusink/Security-Frameworks-and-Models/master/Encryption-OSI-model/Encryption-OSI-model.png)

**Model of Encryption techniques in context to data in transit, in process and at rest**

Data has 3 stages it can be in. It can be in transit between two information
systems, it can be in process within an information system and it can be stored
(at rest) in an information system. All three stages have a different approach
towards encryption. I will talk about the different stages of data from the
OSI-model perspective.

If you want to know more about the OSI-model, click
[here](https://en.wikipedia.org/wiki/OSI_model). In the model above I have added
three additional layers (after a debate with a colleague of mine) to the
OSI-stack. Those are layer 8 Message, layer 9 Transaction and layer 10 Process.
These layers represent the layers that are needed to actually submit a message
to the Application layer. A process can contain multiple transactions, and a
transaction can contain multiple messages.

A message is the actual data itself. Although (meta-)data in and of the
transaction and process layer can be sensitive too. In this post I will focus on
the actual message that is going to be transmitted to another node.

#### 3.1.1. Data in Transit

Encryption of data in transit happens on the 3rd, 5th, 6th and 7th layer of the
OSI-model. Where as layer 3 is information system independent (at least, it
should be), layer 5 through 7 are more depended on what mechanism is chosen in
the application layer. Important here is to know that they are different.

When applying IPSec for IPv4 or IPv6 in your network configuration you will
encrypt the payload of every IP-packet. The header of every IP-packet is, for
obvious reasons of delivery of the payload, not encrypted. There are also two
modus of operandi here. One is host-to-host and the other one is
gateway-to-gateway. I tend to say to go for host-to-host whenever possible as
the route of encryption is the longest there. IPSec secures your data against
unauthorized access on the wire. But anyone that is authorized to the network
can see the data (makes sense I guess).

Transport Layer Security (TLS) is probably the best known protocol to encrypt
data on the wire. It takes residence in the presentation and application layer.
It is used in HTTP connections (the best known are the web-browsers), known as
HTTPS and it is used for FTPS. Do not mistake this with sFTP which uses Secure
Shell (SSH) to encrypt the data. SSH has some weaknesses prior to version 2.
Secure Socket Layer (SSL) and every version of it is considered insecure, just
as TLS 1.0 and 1.1 are. Do not use those protocols anymore!

In summary, TLS version 1.2 and 1.3 and SSH version 2 are safe to use.
Therefore, HTTPS, FTPS and sFTP and other protocols based on TLS and SSH are
also safe to use.

There is also the phenomenon of VPN (Virtual Private Network) Tunneling on layer
2, 3 and 7. In general every VPN tunnel is insecure when additional security
measures are not taken. If you do not trust the underlying network of the VPN
tunnel (for instance, the Internet), then you will have to take security
measures in the VPN tunnel itself. These measures can be protocols like IPSec in
conjunction to Layer 2 Tunneling Protocol (L2TP) or the use of TLS and SSH.

#### 3.1.2. Data in Process

Data in process is the data that is processed by the information system (or
business application if you like). It is everything between data-at-rest and
data-in-transit. As far as I can see, there is hardly any configurable
encryption in this stage. Although it is possible that when the information
system reads the data it also encrypts it in memory.

Although this approach seems to me highly CPU and memory intensive and I doubt
its usefulness for common business-practices here. And it is something the
developers of such an application or the operating system it runs on needs to
implement.

#### 3.1.3. Data at Rest

Data at rest has a filesystem-centric approach towards encryption, and a
data-centric approach. Let’s start with the first one.

The *filesystem-centric* approach is not about the data itself, but the storage
it is stored in. It is about encrypting disks, partitions and volumes (that span
multiple disks or partitions). It is also about an encrypted file in which the
actual data is stored in the form of files and folders. And also your temporary
files in the hibernation and swap space (pagefile) can be encrypted. These last
two are especially important if you want to secure your environment for forensic
analyses.

The *data-centric* approach is the encryption of the data itself. Storing
passwords is probably the most common known variant of it. But it is also
possible to encrypt entire databases or specific records and/or attributes in a
database. The focus here is the data it self, and not the filesystem it is
stored on.

There are tons of examples for implementation here to choose from. There is an
extensive list of [disk encryption
software](https://en.wikipedia.org/wiki/Comparison_of_disk_encryption_software)
on Wikipedia. When selecting your tool for the job, consider your policy towards
hashing and encryption. There might be also other corporate policies that state
whether you should or should not use open source tools. There is no right or
wrong here, other then it is not wise to use software which uses outdated
algorithms.

### 3.2. Implementation and testing

Do not ever trust an implementation without testing. TLS, SSH, IPSec, and the
others might be secure by itself, but these algorithms and protocols are
implemented by software (and hardware in some cases). And software
implementations might have (or probably have) weaknesses also.

Therefore, always perform proper testing before and after implementation and
keep testing it at regular intervals as new vulnerabilities might be discovered
and exploited.

*****

## 4. The Policy in Summary

Well, now it is time to give a summary on topics I have talked about in the
other parts of this repo. In this part I will set-out the guidelines and
if you want more background information on why I choose for some directions,
please check the other posts. I will setup the policy as much as possible on the
way business rules are handled. This to maintain the audit-ability of the
policy.

### 4.1. The Encryption and Hashing Security Policy

#### 4.1.1. General Policy

**Every algorithm that is being used…**

* complies to the Kerckhoffs’s Principle.
* is NOT theoretically or practically compromised or cracked.
* is publically known and commonly used.
* is sufficient enough to keep the data secret for as long as it needs to be secret.
* is considered as part of a Life Cycle program in the organisation.

**Comply or explain…**

Every implementation and use of any encryption algorithm complies to the entire
policy. When it is not technically possible to comply to the policy then:

* Always choose the next best possible option.
* Always do an additional risk-analyses on the chosen option.
* Always implement additional controls when the risk-analyses suggest you should.
* Always perform penetration testing to test for weaknesses.
* Always document the chosen option (explain).

#### 4.1.2. Hashing Policy

**Hashing Algorithm**

* The chosen algorithm is at least SHA-2, with a block size of at least 512-bit, but preferably 1024-bit or higher. And with an output size of at least 256-bit (SHA-256), but preferably 384-bit (SHA-384) or higher.
* MD5 and SHA-1 are never used.

**Salting with Hashing**

* Always salt a message before hashing when used to store passwords / passphrases and other session identifiers.
* Every salt is unique, randomized and not reused anywhere else.
* Every salt is as long as the output size in bytes of a hash.
* Only use one hashing technique for one message.

#### 4.1.3. Encryption Policy

**Symmetric Encryption**

* The chosen Stream Cipher algorithms are ChaCha20. The key-length is at least 128-bit, but preferably 256-bit.
* The chosen Block Cipher algorithm is AES or TwoFish. The key-length is at least 192-bit, but preferably 256-bit.

**Asymmetric Encryption**

* The chosen algorithm is RSA. The key-length is at least 2048-bit, but preferably 3072-bit. The key-length of 1024-bit is never used.
* The Key Agreement is always based on Diffie-Hellman Key Exchange

#### 4.1.4. Implementation Policy

**Data in Transit**

* IPSec is used when ever possible.
* IPv6 is used when ever possible.
* If TLS is used, it is always version 1.2.
* If SSH is used, it is always version 2
* SSL (any version) is never used.

**Data at Rest**

Every option selected for encryption of data at rest…

* is currently maintained by the developer.
* has undergone extensive penetration testing.
* is publically know for its security and is commonly used.
* can use modern day Encryption and Hashing techniques.

#### 4.1.5. Traveling Policy

The Wassenaar Arrangement is an international arrangement between a set of
countries to control the use and export of dual-use goods and technology
([Wikipedia](https://en.wikipedia.org/wiki/Wassenaar_Arrangement) &
[Wassenaar](http://www.wassenaar.org/)). Encryption is considered a
technological dual use good. Therefore, it might be prohibited for people to use
certain encryption technologies (or strengths) in countries that may be
considered as non-friendly or even hostile. This might mean you cannot take an
encrypted phone or laptop with you when traveling.

There is also a chance that when traveling a person must give away his or her
encryption keys when arriving at the customs of the destination country. Many
countries have these laws to check for data on the device that potentially
violate the country’s laws. And when the device is holding critical business
data, it’s security (and secrecy) might be violated.

When traveling…

* the encryption technologies that are used in hardware and software that is taken by the traveler are checked for legality of export by the legal department.
* the devices that are taken do not ever have sensitive data stored locally.
* sensitive data is always collected through a VPN tunnel secured with proper encryption from the organisation’s servers when the person has arrived at its destination.

### 4.2 End-word

That’s about it about the subject of encryption, hashing and its policies.

Thank you for your time to read this repo about the Guidelines for an
Encryption and Hashing Policy.

*****

**) Insecure can mean totally insecure, or ‘only’ when certain terms are met
that the algorithm gets insecure. It can also just be a theoretically insecurity
rather than a practical one. The main message here: if you want or need to use
this algorithm proceed with extra caution and testing.*
